<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Wishlist;
use App\Models\Product;
use App\Models\CustomerAadress;
use App\Models\Country;
use App\Mail\Resetpassword;

class AuthController extends Controller
{
    public function login(){
       return view('front.account.login');
    }

    public function register(){
        return view('front.account.register');
    }

    public function saveRegister(Request $request){
       $validator = Validator::make($request->all(),[
          'name' => 'required',
          'email' => 'required|email|unique:users',
          'phone' => 'required',
          'password' => 'required|min:5|confirmed',
       ]);

       if($validator->passes()){
        $user = new User;

        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->password = Hash::make($request->password);
        $user->save();
        session()->flash('success','Register insert successfully');
        return response()->json([
            'status'=>true,
            'success'=>'Register insert successfully',
          ]);
       }
       else{
          return response()->json([
            'status'=>false,
            'errors'=>$validator->errors(),
          ]);
       }
    }

    public function authenticate(Request $request){
        $validator = Validator::make($request->all(),[
           'email' => 'required|email',
           'password' => 'required',
        ]);

        if($validator->passes()){
          if(Auth::attempt(['email' => $request->email, 'password' => $request->password],$request->get('remember'))){
           if(session()->has('url.intended')){
             return redirect(session()->get('url.intended'));
            }
             return redirect()->route('account.profile');
          }
          else{
               //session()->flash('error','Either email/ password is not correct!!');
               return redirect()->route('account.login')->withErrors($validator)->withInput($request->only('email'))
               ->with('error','Either email/ password is not correct!!');
          }
        }
        else{
            return redirect()->route('account.login')->withErrors($validator)->withInput($request->only('email'));
        }
     }

     public function profile(){

        $data = [];
        $user = User::where('id',Auth::user()->id)->first();
        $useraddress = CustomerAadress::where('user_id',Auth::user()->id)->first();
        $countries = Country::orderBy('id','ASC')->get();

        $data['user'] = $user;
        $data['useraddress'] = $useraddress;
        $data['countries'] = $countries;

        return view('front.account.profile',$data);
     }

     public function updateProfile(Request $request){
        $userId = Auth::user()->id;
        $validator = Validator::make($request->all(),[
            'name' =>'required',
            'email' =>'required|email|unique:users,email,'.$userId.',id',
            'phone' =>'required|numeric',
        ]);
        if($validator->passes()){
            $user = User::find($userId);
            $user->name =  $request->name;
            $user->email =  $request->email;
            $user->phone =  $request->phone;
            $user->save();
            session()->flash('success','profile update successfully!');
            return response()->json([
               'status'=>true,
             ]);
          }
        else{
            session()->flash('error','profile Not update!');
            return response()->json([
               'status'=>false,
               'errors'=>$validator->errors(),
             ]);
        }
     }

     public function updateUserAddress(Request $request){
        $userId = Auth::user()->id;
        $validator = Validator::make($request->all(),[
            'first_name' =>'required',
            'last_name' =>'required',
            'email' =>'required|email',
            'mobile' =>'required|numeric',
            'country' =>'required',
            'address' =>'required',
            'city' =>'required',
            'state' =>'required',
            'zip' =>'required',
        ]);
        if($validator->passes()){

           CustomerAadress::updateOrCreate(
                [
                    'user_id'=>$userId
                ],
                [
                    'first_name' =>  $request->first_name,
                    'last_name'  =>  $request->last_name,
                    'email'      => $request->email,
                    'mobile'     =>  $request->mobile,
                    'country_id' =>  $request->country,
                    'address'    =>  $request->address,
                    'apartment'  =>  $request->apartment,
                    'city'       =>  $request->city,
                    'state'       =>  $request->state,
                    'zip'        =>  $request->zip,
                ]
          );

            session()->flash('success','Address update successfully!');
            return response()->json([
               'status'=>true,
             ]);
          }
        else{
            session()->flash('error','Address Not update!');
            return response()->json([
               'status'=>false,
               'errors'=>$validator->errors(),
             ]);
        }
     }

     public function logout(){
       Auth::logout();
       return redirect()->route('account.login')->with('success','You successfulyy logout');
     }

     public function orders(){
        $user =  Auth::user();
        $orders = Order::where('user_id',$user->id)->orderBy('created_at','DESC')->get();
        $data['orders']= $orders;
        return view('front.account.order',$data);
     }
     public function orderDetail($id){
        $user =  Auth::user();
        $orderDetails = Order::where('user_id',$user->id)->where('id',$id)->first();
        $orderItems = OrderItem::where('order_id',$id)->get();
        $totalOrder = OrderItem::where('order_id',$id)->count();

        $data['orderDetails']= $orderDetails;
        $data['orderItems']= $orderItems;
        $data['totalOrder']= $totalOrder;
        return view('front.account.order-detail',$data);
     }

     public function wishlist(Request $request){
        $data = [];
        $wishlist = Wishlist::where('user_id',Auth::user()->id)->with('product')->get();
        $data['wishlist'] = $wishlist;
        return view('front.account.wishlist',$data);
       }

       public function removeWishlist(Request $request)
       {
        $wishlist = Wishlist::where('user_id',Auth::user()->id)->where('product_id',$request->id)->first();
        if($wishlist == null){
            session()->flash('error','Wishlist Product allready removed!!');
            return response()->json([
               'status'=>true,
             ]);
        }
        else{
            Wishlist::where('user_id',Auth::user()->id)->where('product_id',$request->id)->delete();
            session()->flash('success','Wishlist Product Removed successfully.');
            return response()->json([
            'status'=>true,
            ]);
          }

      }

      public function changePassword(){
        return view('front.account.change-password');
       }

     public function updatePassword(Request $request){

        $validator = Validator::make($request->all(),[
            'old_password'=>'required',
            'new_password' => 'required|min:5',
            'confirm_password' => 'required|same:new_password',
        ]);

        if($validator->passes()){
            $user = User::select('id','password')->where('id', Auth::user()->id)->first();
            if(!Hash::check($request->old_password, $user->password)){
                $errors['old_password'] = 'Old password is not valide';
                return response()->json([
                'status'=>false,
                'errors'=>$errors,
                ]);
              }
             User::where('id',$user->id)->update([
                'password'=>Hash::make($request->new_password)
             ]);
             session()->flash('success','Password Update successfully.');
              return response()->json([
                'status'=>true,
                'errors'=>'Password Update successfully',
                ]);
              }
             else{
             return response()->json([
                'status'=>false,
                'errors'=>$validator->errors(),
                ]);
             }
     }

     public function forGotPassword(){
      return view('front.account.forgot-password');
     }

     public function resetPassword(Request $request){
       $validator = Validator::make($request->all(),[
        'email'=>'required|email|exists:users,email',
       ]);
       if($validator->fails()){
         return redirect()->route('account.forGotPassword')->withInput()->withErrors($validator);
       }
        $token = Str::random(60);
       \DB::table('password_reset_tokens')->where('email',$request->email)->delete();
        \DB::table('password_reset_tokens')->insert([
            'email'=>$request->email,
            'token'=>$token,
            'created_at'=>now(),
        ]);
        //send email here//
        $users = User::where('email',$request->email)->first();
        $forData = [
            'user'=>$users,
            'token'=>$token,
            'subject'=>'You have requested to reset your password.',
        ];
        Mail::to($request->email)->send(new Resetpassword($forData));
        return redirect()->route('account.forGotPassword')->with('success','Please check your email for reset password');
       }

       public function processResetPassword($token){
        $tokenExist = \DB::table('password_reset_tokens')->where('token',$token)->first();
        if($tokenExist ==NULL){
          return redirect()->route('account.forGotPassword')->with('error','Invalid request');
        }
        return view('front.account.reset-password',['token'=>$tokenExist->token]);

       }

       public function doProcessResetPassword(Request $request){
        $tokenObj = \DB::table('password_reset_tokens')->where('token',$request->token)->first();
        if($tokenObj ==NULL){
          return redirect()->route('account.forGotPassword')->with('error','Invalid request');
        }
        $users = User::where('email',$tokenObj->email)->first();

        $validator = Validator::make($request->all(),[
            'new_password'=>'required',
            'confirm_password'=>'required|same:new_password',
           ]);

           if($validator->fails()){
            return redirect()->route('account.processResetPassword',$request->token)->withInput()->withErrors($validator);
           }
           else{
            $users->update([
                'password'=> Hash::make($request->new_password),
            ]);
            \DB::table('password_reset_tokens')->where('email',$users->email)->delete();

            return redirect()->route('account.login')->with('success','Your password reset successfully.');
           }


       }

}
