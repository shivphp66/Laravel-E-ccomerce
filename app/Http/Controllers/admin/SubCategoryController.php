<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use App\Models\Category;
use App\Models\SubCategory;

class SubCategoryController extends Controller
{
    public function index(Request $request)
    {
      $sub_categories =  SubCategory::select('sub_categories.*','categories.name as CategoryName')
      ->latest('sub_categories.id')
      ->leftJoin('categories','categories.id','sub_categories.category_id');

      if (!empty($request->get('keyword'))){       
        $sub_categories =  $sub_categories->where('sub_categories.name','like','%'.$request->get('keyword').'%');
      }
       $sub_categories =  $sub_categories->paginate(10);

        return view('admin.sub_category.list',compact('sub_categories'));

    }

    public function create(){      
      $categories = Category::where('status',1)->get();
       return view('admin.sub_category.create',compact('categories'));
        
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'category'=>'required',
            'name'=> 'required',
            'slug'=>'required|unique:sub_categories',
            
          ]);

          if($validator->passes())
          {
            $sub_categories =  new SubCategory(); 
            $sub_categories->category_id =  $request->category;           
            $sub_categories->name =  $request->name;
            $sub_categories->slug =  $request->slug; 
            $sub_categories->status =  $request->status;
            $sub_categories->showHome =  $request->showHome;   
            $sub_categories->save();

            $request->session()->flash('success','Sub Category added successfully');
            return response()->json([
                'status' => true,
                'message' => 'Sub Category added successfully'
              ]);
          
        }else{
                return response()->json([
                    'status' => false,
                    'errors' => $validator->errors()
                ]);
              }
        
    }

    public function edit($sub_categoryId, Request $request)
    {
      $categories = Category::where('status',1)->get();

      $sub_category = SubCategory::find($sub_categoryId);

      if(empty($sub_category)){
        return redirect()->route('sub-categories.index');
      }
       return view('admin.sub_category.edit',compact('sub_category','categories'));

    }

    public function update($sub_categoryId, Request $request)
    {

      $sub_category = SubCategory::find($sub_categoryId);

      //dd($sub_category);

      if(empty($sub_category)){
        $request->session()->flash('error','Sub Category Not Found!');
        return response()->json([
          'status' => false,
          'notFound'=>true,
          'data'=>$sub_category,
          'errors' => 'Sub Category not found!!'
      ]);
      }

      $validator = Validator::make($request->all(),[
        'name'=> 'required',
        'slug'=>'required|unique:sub_categories,slug,'.$sub_category->id.',id',
      ]);

      if($validator->passes())
      {       
       // $category = new Category();
        $sub_category->category_id = $request->category;
        $sub_category->name =  $request->name;
        $sub_category->slug =  $request->slug; 
        $sub_category->status =  $request->status;
        $sub_category->showHome =  $request->showHome;  
        $sub_category->save();

          $request->session()->flash('success','Sub Category Update successfully');
              return response()->json([
                  'status' => true,
                  'message' => 'Sub Category Update successfully'
                ]);
            
              }else{
                      return response()->json([
                          'status' => false,
                          'errors' => $validator->errors()
                      ]);
                  }
        
    }

    
    public function destroy($sub_categoryId, Request $request)
    {
      $sub_category = SubCategory::find($sub_categoryId);
      if(empty($sub_category)){
        //return redirect()->route('categories.index');
        $request->session()->flash('error','Sub Category not found');
         return response()->json([
          'status' => true,
          'message' => 'Sub Category not found'
      ]);
      }

         $sub_category->delete();         
         $request->session()->flash('success','Sub Category delete successfully');
         return response()->json([
          'status' => true,
          'message' => 'Sub Category delete successfully'
      ]);    
        
    }
}
