<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use App\Models\Brands;

class BrandController extends Controller
{
   public function index(Request $request)
   {
        $brands = Brands::latest();
        if (!empty($request->get('keyword'))){
            $brands =  $brands->where('name','like','%'.$request->get('keyword').'%');
          }
         $brands =  $brands->paginate(10);
        return view('admin.brands.list',compact('brands'));

   }

   public function create()
   {
    return view('admin.brands.create');
  }

  public function store(Request $request)
  {
    $validator = Validator::make($request->all(),[
                'name' => 'required',
                'slug' => 'required',

                ]);
        if($validator->passes())
        {
            $brands = new Brands();
            $brands->name = $request->name;
            $brands->slug = $request->slug;
            $brands->status = $request->status;
            $brands->save();

            $request->session()->flash('success','Brand added successfully');
            return response()->json([
                'status' => true,
                'message' => 'Brand added successfully'
              ]);

        }else{
                return response()->json([
                    'status' => false,
                    'errors' => $validator->errors()
                ]);
              }
     }

    public function edit($barandID, Request $request)
    {
       $brands = Brands::find($barandID);
       if(empty($brands)){
        return redirect()->route('brands.index');
       }
       return view('admin.brands.edit',compact('brands'));
    }

    public function update($barandID, Request $request)
    {
        $brands = Brands::find($barandID);
        if(empty($brands))
         {
            $request->session()->flash('error','Brand Not Found!');
            return response()->json([
              'status' => false,
              'notFound'=>true,
              'errors' => 'Brand not found!!'
             ]);
          }

          $validator = Validator::make($request->all(),[
            'name'=> 'required',
            'slug'=>'required|unique:Brands,slug,'.$brands->id.',id',
          ]);

         if($validator->passes()){

            $brands->name = $request->name;
            $brands->slug = $request->slug;
            $brands->status = $request->status;
            $brands->save();

            $request->session()->flash('success','Brand update successfully!');
            return response()->json([
              'status' => true,
              'message' => 'Brand update successfully!'
          ]);
         }

    }


    public function destroy($barandID, Request $request)
    {
        $brands = Brands::find($barandID);
        $brands->delete();
        $request->session()->flash('success','Brand Deteted!');
            return response()->json([
              'status' => true,
              'message' => 'Brand Deteted!'
          ]);

    }

}
