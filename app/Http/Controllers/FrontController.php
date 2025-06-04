<?php

namespace App\Http\Controllers;
use App\Mail\ContactEmail;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Wishlist;
use App\Models\Page;
use App\Models\User;
use App\Models\Banner;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;

class FrontController extends Controller
{
   public function index(){
      $feturedProduct = Product::where('is_featured','Yes')->where('status','1')->get();
      $latestProduct = Product::orderBy('id','DESC')->where('status','1')->limit('12')->get();
      $banners = Banner::where('status',1)->get();

      $data['feturedProduct'] = $feturedProduct;
      $data['latestProduct'] = $latestProduct;
      $data['banners'] = $banners;
    return view('front.home',$data);
   }

   public function addToWishlist(Request $request){
     if(Auth::check() == false){
        session(['url.intended' =>url()->previous()]);
      return response()->json([
        'status'=>false,
      ]);
     }
     $product = Product::where('id',$request->id)->first();
     if($product == null){
        return response()->json([
            'status'=>true,
            'message'=>'<div class="alert alert-danger">Product not found!!</div>',
          ]);
     }

     Wishlist::updateOrCreate(
        ['user_id' =>Auth::user()->id, 'product_id' => $request->id],
        ['user_id' =>Auth::user()->id, 'product_id' => $request->id]
     );

     return response()->json([
        'status'=>true,
        'message'=>'<div class="alert alert-success"><strong>"'.$product->title.'"</strong> Product added in your wishlist</div>',
      ]);
   }

    public function page($slug){
      $page = Page::where('slug',$slug)->first();
      if($page == NULL){
            abort(404);
      }
      return view('front.page',['page'=>$page]);
    }

    public function sendContactEmail(Request $request){
      $Validator = Validator::make($request->all(),[
        'name'=>'required',
        'email'=>'required|email',
        'subject'=>'required',
        'message'=>'required',
      ]);

     if($Validator->passes()){
        $emailData = [
           'name'=>$request->name,
           'email'=>$request->email,
           'subject'=>$request->subject,
           'message'=>$request->message,
           'mail_subject'=>'You have revieved a contact email',
        ];
       $user = User::where('id',Auth::guard('admin')->user()->id )->first();
        Mail::to($user->email)->send(new ContactEmail($emailData));

        session()->flash('success','You have send Contact us email successfully.');
        return response()->json([
            'status'=>true,
        ]);
     }
     else{
        return response()->json([
            'status'=>false,
            'errors'=>$Validator->errors(),
        ]);
     }
    }

}
