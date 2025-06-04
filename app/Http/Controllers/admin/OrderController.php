<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Country;
use App\Models\CustomerAadress;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\DiscountCoupon;
use App\Models\ShippingCharge;
use App\Models\User;
use Illuminate\Http\Request;

class OrderController extends Controller
{
   public function index(Request $request){

    $orders = Order::latest('orders.created_at')->select('orders.*','users.email','users.name');
    $orders = $orders->leftJoin('users','users.id','orders.user_id');

    if($request->get('keyword') !=''){
        $orders = $orders->where('users.name','like','%'.$request->get('keyword').'%');
        $orders = $orders->orWhere('users.email','like','%'.$request->get('keyword').'%');
        $orders = $orders->orWhere('orders.id','like','%'.$request->get('keyword').'%');
    }
    $orders = $orders->paginate(10);

    return view('admin.orders.list',['orders'=>$orders]);

   }

   public function details($orderId){
    $order = Order::select('orders.*','countries.name as countryName')->where('orders.id',$orderId)
    ->leftjoin('countries','countries.id','orders.country_id')->first();
    $orderItems = OrderItem::where('order_id',$orderId)->get();
    return view('admin.orders.detail',['order'=>$order,'orderItems'=>$orderItems]);
   }

   public function chageOrderStatus(Request $request, $orderId){
    $order = Order::find($orderId);
    $order->status = $request->status;
    $order->shipped_date = $request->shipped_date;

    $order->save();
    session()->flash('success','Order status change successfully.');
    return response()->json([
        'status'=>true,
        'message'=>'Order status change successfully.'
    ]);
   }

   public function sendInvoiceEmail(Request $request, $id){
    orderEmail($id, $request->users);

    session()->flash('success','You have send Invoice mail successfully.');
    return response()->json([
        'status'=>true,
        'message'=>'You have send Invoice mail successfully.'
    ]);
   }
}
