<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DiscountCoupon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Carbon;

class DiscountCodeController extends Controller
{
   public function index(Request $request){

    $discountCoupon =  DiscountCoupon::latest();

    if (!empty($request->get('keyword'))){
        $coupenCode =  $discountCoupon->where('code','like','%'.$request->get('keyword').'%');
        $coupenCode =  $discountCoupon->orWhere('name','like','%'.$request->get('keyword').'%');
      }

      $coupenCode =  $discountCoupon->paginate(10);

    return view('admin.coupons.list',['discountCoupon'=>$coupenCode]);
   }

   public function create(){
    return view('admin.coupons.create');
   }
   public function store(Request $request){
      $validator = Validator::make($request->all(),[
         'code' => 'required',
         'discount_amount' => 'required|numeric',
         'status' => 'required',
         'type' => 'required',
      ]);

      if($validator->passes()){
         if(!empty($request->starts_at)){
            $now = Carbon::now();
            $statAt = Carbon::createFromFormat('Y-m-d H:i:s',$request->starts_at);

            if($statAt->lte($now) == true){
                return response()->json([
                    'status'=>false,
                    'errors' => ['starts_at'=>'Start date can not less than current date time']
                   ]);
            }
         }

            if(!empty($request->starts_at) && !empty($request->expires_at)){
               $statAt = Carbon::createFromFormat('Y-m-d H:i:s',$request->starts_at);
               $expiresAt = Carbon::createFromFormat('Y-m-d H:i:s',$request->expires_at);

               if($expiresAt->gt($statAt) == false){
                   return response()->json([
                       'status'=>false,
                       'errors' => ['expires_at'=>'Expiry date can not less than start date']
                      ]);
               }
            }


       $discountCoupon = new DiscountCoupon();

       $discountCoupon->code = $request->code;
       $discountCoupon->name = $request->name;
       $discountCoupon->description = $request->description;
       $discountCoupon->max_uses = $request->max_uses;
       $discountCoupon->max_uses_user = $request->max_uses_user;
       $discountCoupon->type = $request->type;
       $discountCoupon->discount_amount = $request->discount_amount;
       $discountCoupon->min_amount = $request->min_amount;
       $discountCoupon->status = $request->status;
       $discountCoupon->starts_at = $request->starts_at;
       $discountCoupon->expires_at = $request->expires_at;
       $discountCoupon->save();
       session()->flash('success', 'Discount Coupon added successfully');
       return response()->json([
        'status'=>true,
        'message' => 'Discount Coupon added successfully'
       ]);
      }

      else{
        return response()->json([
            'status'=>false,
            'errors'=>$validator->errors(),
        ]);
      }
   }

   public function edit($id){
    $coupenCode =  DiscountCoupon::find($id);
    if($coupenCode == null){
        return redirect()->route('coupons.index');
    }

    return view('admin.coupons.edit',['coupenCode'=>$coupenCode]);
   }

   public function update(Request $request,$id){
    $discountCoupon = DiscountCoupon::find($id);
    if($discountCoupon == null){
        session()->flash('error', 'Recode not found!!');
        return response()->json(['status'=>true]);
        }

            $validator = Validator::make($request->all(),[
                'code' => 'required',
                'discount_amount' => 'required|numeric',
                'status' => 'required',
                'type' => 'required',
            ]);

            if($validator->passes()){

                if(!empty($request->starts_at) && !empty($request->expires_at)){
                    $statAt = Carbon::createFromFormat('Y-m-d H:i:s',$request->starts_at);
                    $expiresAt = Carbon::createFromFormat('Y-m-d H:i:s',$request->expires_at);

                    if($expiresAt->gt($statAt) == false){
                        return response()->json([
                            'status'=>false,
                            'errors' => ['expires_at'=>'Expiry date can not less than start date']
                            ]);
                        }
                    }

                    $discountCoupon->code = $request->code;
                    $discountCoupon->name = $request->name;
                    $discountCoupon->description = $request->description;
                    $discountCoupon->max_uses = $request->max_uses;
                    $discountCoupon->max_uses_user = $request->max_uses_user;
                    $discountCoupon->type = $request->type;
                    $discountCoupon->discount_amount = $request->discount_amount;
                    $discountCoupon->min_amount = $request->min_amount;
                    $discountCoupon->status = $request->status;
                    $discountCoupon->starts_at = $request->starts_at;
                    $discountCoupon->expires_at = $request->expires_at;
                    $discountCoupon->save();
                    session()->flash('success', 'Discount Coupon updated successfully');
                    return response()->json([
                    'status'=>true,
                    'message' => 'Discount Coupon updated successfully'
                    ]);
                    }

               else{
                return response()->json([
                    'status'=>false,
                    'errors'=>$validator->errors(),
                ]);
            }
   }

   public function destroy(Request $request,$id){
    $discountCoupon = DiscountCoupon::find($id);
      if($discountCoupon == null){
        session()->flash('error', 'Recode not found!!');
        return response()->json(['status'=>true]);
     }
     $discountCoupon->delete();

     session()->flash('success', 'Coupen code delete successfully.');
     return response()->json([
        'status'=>true
        ]);
   }
}
