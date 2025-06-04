<?php

namespace App\Http\Controllers\admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use App\Models\Category;
use App\Models\TempImage;
//use Intervention\Image\ImageManager;
//use Illuminate\View\View;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
      $categories =  Category::latest();
      if (!empty($request->get('keyword'))){

        $categories =  $categories->where('name','like','%'.$request->get('keyword').'%');
      }

      $categories =  $categories->paginate(10);
      return view('admin.category.list',compact('categories')); 

      /*return view('admin.category.list', [
        'categories' => DB::table('categories')->paginate(10)
    ]);*/

    }

    public function create(){
        return view('admin.category.create');
    }
    public function store(Request $request)
    {
       $validator = Validator::make($request->all(),[
            'name'=> 'required',
            'slug'=>'required|unique:categories'
          ]);

          if($validator->passes())
          {
            $category = new Category();
            $category->name =  $request->name;
            $category->slug =  $request->slug; 
            $category->status =  $request->status;
            $category->showHome =  $request->showHome; 
            $category->save();

            if(!empty($request->image_id)){
              $TempImage = TempImage::find($request->image_id);

              $extArray = explode('.',$TempImage->name);
              $ext = last($extArray);
              $newImgeName = $category->id.'.'.$ext;
              $sPath = public_path().'/temp/'.$TempImage->name;
              $dPath = public_path().'/uploads/category/'.$newImgeName;
              FILE::copy($sPath,$dPath);

              //Generate image Thumbnale//
              $dPath = public_path().'/uploads/category/thumb/'.$newImgeName;
              //$img = Image::make($sPath);

              $manager = new ImageManager(new Driver());
              $image = $manager->read($sPath);
              $image->cover(450, 600);
              $image->save($dPath);
              $category->image =  $newImgeName; 
              $category->save();
            }
            
           $request->session()->flash('success','Category added successfully');
              return response()->json([
                  'status' => true,
                  'message' => 'Category added successfully'
                ]);
            
          }else{
                  return response()->json([
                      'status' => false,
                      'errors' => $validator->errors()
                  ]);
                }
        
    }

    public function edit($categoryId, Request $request)
    {
      $category = Category::find($categoryId);

      if(empty($category)){
        return redirect()->route('categories.index');
      }
       return view('admin.category.edit',compact('category'));

    }
    public function update($categoryId, Request $request)
    {
      $category = Category::find($categoryId);

      if(empty($category)){
        $request->session()->flash('error','Category Not Found!');
        return response()->json([
          'status' => false,
          'notFound'=>true,
          'errors' => 'Category not found!!'
      ]);
      }

      $validator = Validator::make($request->all(),[
        'name'=> 'required',
        'slug'=>'required|unique:categories,slug,'.$category->id.',id',
      ]);

      if($validator->passes())
      {
       // $category = new Category();
        $category->name =  $request->name;
        $category->slug =  $request->slug; 
        $category->status =  $request->status;
        $category->showHome =  $request->showHome;  
        $category->save();

        $oldImage = $category->image;

        if(!empty($request->image_id)){
          $TempImage = TempImage::find($request->image_id);

          $extArray = explode('.',$TempImage->name);
          $ext = last($extArray);
          $newImgeName = $category->id.'-'.time().'.'.$ext;
          $sPath = public_path().'/temp/'.$TempImage->name;
          $dPath = public_path().'/uploads/category/'.$newImgeName;
          FILE::copy($sPath,$dPath);

          //Generate image Thumbnale//
          $dPath = public_path().'/uploads/category/thumb/'.$newImgeName;
          //$img = Image::make($sPath);

          $manager = new ImageManager(new Driver());
          $image = $manager->read($sPath);
          $image->cover(450, 600);
          $image->save($dPath);
          $category->image =  $newImgeName; 
          $category->save();

          //Delete old image here//

          File::delete(public_path().'/uploads/category/'.$oldImage);
          File::delete(public_path().'/uploads/category/thumb/'.$oldImage);
        }
        
          $request->session()->flash('success','Category added successfully');
              return response()->json([
                  'status' => true,
                  'message' => 'Category added successfully'
                ]);
            
              }else{
                      return response()->json([
                          'status' => false,
                          'errors' => $validator->errors()
                      ]);
                    }
    }

    public function destroy($categoryId, Request $request)
    {
      $category = Category::find($categoryId);

      if(empty($category)){
        //return redirect()->route('categories.index');
        $request->session()->flash('error','Category not found');
         return response()->json([
          'status' => true,
          'message' => 'Category not found'
      ]);
      }

          File::delete(public_path().'/uploads/category/'.$category->image);
          File::delete(public_path().'/uploads/category/thumb/'.$category->image);

         $category->delete();         
         $request->session()->flash('success','Category delete successfully');
         return response()->json([
          'status' => true,
          'message' => 'Category delete successfully'
      ]);
    }

}
