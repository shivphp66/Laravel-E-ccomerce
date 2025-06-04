<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Gloudemans\Shoppingcart\Facades\Cart;
use App\Models\Product;
use App\Models\Country;
use App\Models\CustomerAadress;
use App\Models\Order;
use App\Models\User;
use App\Models\OrderItem;
use App\Models\DiscountCoupon;
use App\Models\ShippingCharge;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Carbon;
use App\Events\OrderEmail;

class CartController extends Controller
{
    public function addToCart(Request $request){
       $product = Product::with('product_image')->find($request->id);
       if($product == NULL){
           return response()->json([
              "status" => false,
              "message" => "Recode not found"
           ]);
       }

       if(Cart::count() > 0){
            $cartContent = Cart::content();
            $productAlredyExit = false;
            foreach($cartContent as $item){
               if($item->id == $product->id){
                $productAlredyExit = true;
               }
            }
            if($productAlredyExit == false){
                Cart::add($product->id, $product->title, 1, $product->price,["productImage"=>(!empty($product->product_image)) ? $product->product_image->first() : '']);
                $satatus = true;
                $message = '<strong>'.$product->title.'</strong> Item Added in cart successfully.';
                session()->flash('success',$message);
            }
            else{
                $satatus = false;
                $message = $product->title.' Already added in cart.';
            }
         }
         else{
            Cart::add($product->id, $product->title, 1, $product->price,["productImage"=>(!empty($product->product_image)) ? $product->product_image->first() : '']);
            $satatus = true;
            $message = '<strong>'.$product->title.'</strong> Item Added in cart successfully.';
            session()->flash('success',$message);
         }
       return response()->json([
        "status" =>  $satatus,
        "message" => $message
     ]);
    }

    public function cart(){
       $cartContent = Cart::content();
       $data['cartContent'] = $cartContent;
       return view('front.cart',$data);
    }

    public function updateCart(Request $request){
     //check qty is available
       $rowId = $request->rowId;
       $qty = $request->qty;
       $productInfo = Cart::get($rowId);
       $product = Product::find($productInfo->id);
       if($product->track_qty == 'Yes'){
          if($qty <= $product->qty){
            Cart::update($rowId,$qty);
            $message = "Cart updated successfully";
            $status = true;
            session()->flash('success',$message);
          }
          else{
              $message = "Request qty ($qty) is not available in stock";
              $status = false;
              session()->flash('error',$message);
             }
         }
         else{
            Cart::update($rowId, $qty);
            $message = "Cart updated successfully";
            $status = true;
            session()->flash('success',$message);
           }
        return response()->json([
             'status'=> $status,
             'message'=> $message
        ]);
     }

    public function deleteItem(Request $request){
        $produtInfo = Cart::get($request->rowId);
        if($produtInfo == NULL){
            $ErrorMessage = "Item not found in cart";
            session()->flash('error',$ErrorMessage);
            return response()->json([
                'status'=> false,
                'message'=> $ErrorMessage
           ]);
        }

        else{
            Cart::remove($request->rowId);
            $message = "Item Remove from cart successfully";
            session()->flash('success',$message);
            return response()->json([
                'status'=> true,
                'message'=> $message
            ]);
        }
    }

    public function checkout(Request $request){
        $discount = 0;
        $customerAadress = '';
        $userCountry = '';
        if(Cart::count() == 0){
            return redirect()->route('front.cart');
        }
        if(Auth::check() == false){
            if(session()->has('url.intended') == ""){
                session(['url.intended'=> url()->current()]);
               return redirect()->route('account.login');
            }
         }

         session()->forget('url.intended');
         $countries = Country::orderBy('name','ASC')->get();
         $subTotal = Cart::subtotal(2,'.','');

          //Apply Discount coupon//

            if(session()->has('code')){
                $code = session()->get('code');
                if($code->type == 'percent'){
                  $discount = ($code->discount_amount/100)*$subTotal;
                }
                else{
                    $discount = $code->discount_amount;
                }
            }

        //calculate shipping here//

        if(Auth::check() != false){
            $customerAadress = CustomerAadress::where('user_id', Auth::user()->id)->first();
            if($customerAadress !=''){
               $userCountry = $customerAadress->country_id;
            }
            $totalQty = 0;
            $totalShippingCharge = 0;
            $grandTotal = 0;
            $shippingInfo = ShippingCharge::where('country_id',$userCountry)->first();
            if($shippingInfo != null){
                foreach(Cart::content() as $itme){
                    $totalQty += $itme->qty;
                }
                $totalShippingCharge = $totalQty*$shippingInfo->amount;
                $grandTotal = ($subTotal-$discount)+$totalShippingCharge;
            }
            else{
                $shippingInfo = ShippingCharge::where('country_id','rest_of_world')->first();
                foreach(Cart::content() as $itme){
                    $totalQty += $itme->qty;
                }
                $totalShippingCharge = $totalQty*$shippingInfo->amount;
                $grandTotal = ($subTotal-$discount)+$totalShippingCharge;
            }
        }
        else{
            $totalShippingCharge = 0;
            $grandTotal = ($subTotal-$discount);
        }
        return view('front.checkout',[
            'countries'=>$countries,
            'customerAadress'=>$customerAadress,
            'totalShippingCharge'=>$totalShippingCharge,
            'discount'=>$discount,
            'grandTotal'=>$grandTotal,
        ]);
    }

    public function processCheckout(Request $request){

       $validator = Validator::make($request->all(),[
        'first_name' => 'required',
        'last_name' => 'required',
        'email' => 'required|email',
        'country' => 'required',
        'address' => 'required',
        'city' => 'required',
        'state' => 'required',
        'zip' => 'required',
        'mobile' => 'required',
        ]);
        if($validator->fails()){
            return response()->json([
                'status'=>false,
                'message'=>'Please fix the error',
                'errors' => $validator->errors(),

            ]);
        }
       $user = Auth::user();
       CustomerAadress::updateOrCreate(
        ['user_id'=> $user->id],
        [
            'user_id'    =>$user->id,
            'first_name' =>$request->first_name,
            'last_name'  =>$request->last_name,
            'email'      =>$request->email,
            'mobile'     =>$request->mobile,
            'country_id' =>$request->country,
            'address'    =>$request->address,
            'apartment'  =>$request->apartment,
            'city'       =>$request->city,
            'state'      =>$request->state,
            'zip'        =>$request->zip,
        ]);

        if($request->payment_method=='COD'){
     //calculate shipping methods//
        $shipping = 0;
        $discount = 0;
        $couponCode = '';
        $promoCode = '';
        $couponCodeId = '';
        $subTotal = Cart::subtotal(2,'.','');

         //Apply Discount coupon//
        if(session()->has('code')){
            $code = session()->get('code');

            if($code->type == 'percent'){
              $discount = ($code->discount_amount/100)*$subTotal;
             }
            else{
                $discount = $code->discount_amount;
            }
            $couponCodeId = $code->id;
            $promoCode = $code->code;
          }



         $shippingInfo = ShippingCharge::where('country_id',$request->country)->first();
         $totalQty = 0;
         foreach(Cart::content() as $itme){
            $totalQty += $itme->qty;
         }
         if($shippingInfo !=null){
             $shipping =  $shippingInfo->amount*$totalQty;
             $grandTotal = ($subTotal-$discount)+$shipping;
         }
         else{
             $shippingInfo = ShippingCharge::where('country_id','rest_of_world')->first();
             $shipping =  $shippingInfo->amount*$totalQty;
             $grandTotal = ($subTotal-$discount)+$shipping;
           }

          $order = new Order();

          $order->subtotal = $subTotal;
          $order->shipping = $shipping;
          $order->coupon_code = $promoCode;
          $order->coupon_code_id = $couponCodeId;
          $order->discount = $discount;
          $order->grand_total = $grandTotal;
          $order->payment_status = 'not paid';
          $order->status ='pending';
          $order->user_id = $user->id;
          $order->first_name = $request->first_name;
          $order->last_name = $request->last_name;
          $order->email = $request->email;
          $order->country_id = $request->country;
          $order->apartment = $request->apartment;
          $order->address = $request->address;
          $order->mobile = $request->mobile;
          $order->city = $request->city;
          $order->state = $request->state;
          $order->zip = $request->zip;
          $order->notes = $request->order_notes;
          $order->save();

         //data store in order item//
          foreach(Cart::content() as $item){
           $orderItem = new OrderItem();

           $orderItem->order_id = $order->id;
           $orderItem->product_id = $item->id;
           $orderItem->name = $item->name;
           $orderItem->qty = $item->qty;
           $orderItem->price = $item->price;
           $orderItem->total = $item->price*$item->qty;
           $orderItem->save();

           //update qty//

           $product = Product::find($item->id);
           if($product->track_qty == 'Yes'){
            $qty = $product->qty - $item->qty;
            $product->qty = $qty;
            $product->save();
           }
          }
          //send order email//

           //orderEmail($order->id,'customer');

           OrderEmail::dispatch($order->id,'customer');

            session()->flash('success', 'You have successfully plased your order');
            Cart::destroy();
            session()->forget('code');
            return response()->json([
                'status'=>true,
                'message'=>'Order save successfully',
                'orderId'=>$order->id
             ]);
           }
    }

    public function thankyou($id){
        return view('front.thanks',['id'=>$id]);
    }

    public function getOrderSummery(Request $request){
      $subTotal = Cart::subtotal(2,'.','');
      $discount = 0;
      $discoutString = '';
      //Apply Discount coupon//
      if(session()->has('code')){
         $code = session()->get('code');
         if($code->type == 'percent'){
            $discount = ($code->discount_amount/100)*$subTotal;
         }
         else{
            $discount = $code->discount_amount;
         }

         $discoutString = '<div class="mt-4" id="discount-response">
         <strong>'.session()->get('code')->code.'</strong>
         <a class="btn btn-sm btn-danger" id="remove-discount"><i class="fa fa-times" ></i></a>
         </div>';
      }
      if($request->country_id > 0){
        $totalQty = 0;
        foreach(Cart::content() as $itme){
           $totalQty += $itme->qty;
        }
        $shippingInfo = ShippingCharge::where('country_id',$request->country_id)->first();

        if($shippingInfo !=null){
            $shippingCharge =  $shippingInfo->amount*$totalQty;
            $grandTotal = ($subTotal-$discount)+$shippingCharge;
            return response()->json([
                'status' =>true,
                'grandTotal' =>number_format($grandTotal,2),
                'discount' => number_format($discount),
                'discoutString' =>$discoutString,
                'shippingCharge' =>number_format($shippingCharge,2)
            ]);
        }
        else{
            $shippingInfo = ShippingCharge::where('country_id','rest_of_world')->first();
            $shippingCharge =  $shippingInfo->amount*$totalQty;
            $grandTotal = ($subTotal-$discount)+$shippingCharge;
            return response()->json([
                'status' =>true,
                'grandTotal' =>number_format($grandTotal,2),
                'discount' => number_format($discount),
                'discoutString' =>$discoutString,
                'shippingCharge' =>number_format($shippingCharge,2)
            ]);
          }
      }
      else{
        return response()->json([
            'status' =>true,
            'grandTotal' =>number_format(($subTotal-$discount),2),
            'discount' => number_format($discount),
            'discoutString' =>$discoutString,
            'shippingCharge' =>number_format(0,2)
        ]);
      }
    }

    public function applyDiscount(Request $request){
       $code = DiscountCoupon::where('code',$request->code)->first();
       if($code == null){
        return response()->json([
            'status'=>false,
            'error'=>'Invalid discount coupon!',
            ]);
        }
      // check coupon code is valide or not//

       $now = Carbon::now();
       if($code->starts_at !=""){
         $startDate = Carbon::createFromFormat('Y-m-d H:i:s',$code->starts_at);
         if($now->lt($startDate)){
            return response()->json([
                'status'=>false,
                'error'=>'Invalid discount coupon code!',
                ]);
             }
         }
       if($code->expires_at !=""){
        $endDate = Carbon::createFromFormat('Y-m-d H:i:s',$code->expires_at);
        if($now->gt($endDate ) ){
           return response()->json([
               'status'=>false,
               'error'=>'Invalid discount coupon code!',
               ]);
           }
        }
       //Max uses check//
       if($code->max_uses > 0){
        $couponUsed = Order::where('coupon_code_id', $code->id)->count();
        if($couponUsed >= $code->max_uses){
        return response()->json([
            'status'=>false,
            'error'=>'This coupon code already used!',
            ]);
         }
       }

      //Max uses users//
      if($code->max_uses_user > 0){
      $couponUsedByUser = Order::where(['coupon_code_id'=> $code->id,'user_id'=>Auth::user()->id])->count();
      if($couponUsedByUser >= $code->max_uses_user){
        return response()->json([
            'status'=>false,
            'error'=>'You already used this coupon!',
            ]);
      }
    }
    //minimum amount condition ckeck//

    $subTotal = Cart::subtotal(2,'.','');
    if($code->min_amount > 0){
        if($subTotal < $code->min_amount){
            return response()->json([
                'status'=>false,
                'error'=>'You Min amount must be ₹'.$code->min_amount.'.'
                ]);
        }

    }
      session()->put('code',$code);
      return $this->getOrderSummery($request);
    }

    public function removeCoupen(Request $request){
      session()->forget('code');
      return $this->getOrderSummery($request);
    }
}



