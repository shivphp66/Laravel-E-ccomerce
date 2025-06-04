<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\ShippingCharge;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ShippingController extends Controller
{
    public function create(){
       $countries = Country::get();
       $shippingcharges = ShippingCharge::select('shipping_charges.*','countries.name')->leftJoin('countries','countries.id','shipping_charges.country_id')->get();

      return view('admin.shipping.create',['countries'=>$countries,'shippingcharges'=>$shippingcharges]);
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(),[
            'country' => 'required',
            'amount' => 'required|numeric',
        ]);

        if($validator->passes()){
            $count = ShippingCharge::where('country_id',$request->country)->count();
            if($count > 0){
                session()->flash('error','Shipping already added!');
                return response()->json([
                    'status'=>true,
                ]);
            }

            $shipping = new ShippingCharge();
            $shipping->country_id = $request->country;
            $shipping->amount = $request->amount;
            $shipping->save();
            session()->flash('success','Shipping added successfully!!');
            return response()->json([
                'status'=>true,
                'message'=>'shipping save successfully',
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
        $countries = Country::get();
        $shippingcharge = ShippingCharge::find($id);

       return view('admin.shipping.edit',['countries'=>$countries,'shippingcharge'=>$shippingcharge]);

    }

    public function update($id,Request $request){
        $validator = Validator::make($request->all(),[
            'country' => 'required',
            'amount' => 'required|numeric',
        ]);

        if($validator->passes()){

            $shipping = ShippingCharge::find($id);
            if($shipping == null){
                session()->flash('error','Shipping not found!');
                return response()->json([
                    'status'=>true,
                ]);
            }

            $shipping->country_id = $request->country;
            $shipping->amount = $request->amount;
            $shipping->save();
            session()->flash('success','Shipping update successfully!!');
            return response()->json([
                'status'=>true,
                'message'=>'shipping update successfully',
            ]);
        }

        else{
            return response()->json([
            'status'=>false,
            'errors'=>$validator->errors(),
            ]);
        }
    }



    public function destroy($id){
        $ShippingCharge = ShippingCharge::find($id);
        if($ShippingCharge == null){
            session()->flash('error','Shipping not found!');
            return response()->json([
                'status'=>true,
            ]);
        }
        $ShippingCharge->delete();

        session()->flash('success','Shipping delete successfully!');
            return response()->json([
                'status'=>true
            ]);
    }
}
