<?php
//use App\Mail\OrderEmail;
use App\Models\Category;
use App\Models\ProductImage;
use App\Models\Order;
use App\Models\Country;
use App\Models\Page;
use Illuminate\Support\Facades\Mail;

 function getCategories(){
    return Category::orderBy('name','ASC')->with('sub_categories')->where('showHome','Yes')->where('status','1')->get();
 }

 function getProductImage($producId){
    return ProductImage::where('product_id',$producId)->first();
 }

 /*function orderEmail($orderId,$userType="customer"){
   $order = Order::where('id',$orderId)->with('items')->first();
   if($userType=="customer"){
       $subject = "Thanks for your order";
       $email = $order->email;
   }
   else{
        $subject = "You have rivieved ad order";
        $email = env('ADMIN_EMAIL');
   }
   $mailData = ['subject' =>$subject,'order'=>$order,'userType'=>$userType];
   Mail::to($email)->send(new OrderEmail($mailData));
 }*/

 function getCountryInfo($countryID){
    return Country::where('id',$countryID)->first();
 }

 function getPages(){
    return Page::where('status','1')->orderBy('created_at','DESC')->get();
 }


?>
