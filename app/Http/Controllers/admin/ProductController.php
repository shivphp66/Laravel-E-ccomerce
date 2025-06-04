<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\Brands;
use App\Models\Product;
use App\Models\TempImage;
use App\Models\ProductImage;
use App\Models\ProductRating;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class ProductController extends Controller
{
    public function index(Request $request){
        $product = Product::latest('id')->with("product_image");
        if($request->get('keyword') != ""){
          $product = $product->where('title','like','%'.$request->keyword.'%');
        }
      $product = $product->paginate(10);
        return view('admin.products.list',compact('product'));
    }

   public function create(){
     $categories = Category::orderBy('name','ASC')->get();
     $subcategories = SubCategory::orderBy('name','ASC')->get();
     $brands = Brands::orderBy('name','ASC')->get();
     $data['categories'] = $categories;
     $data['subcategories'] = $subcategories;
     $data['brands'] = $brands;
     return view('admin.products.create',$data);
   }

   public function store(Request $request)
   {
     $validator = Validator::make($request->all(),[
            'title'=>'required',
            'slug'=>'required',
            'price'=> 'required|numeric',
            'barcode'=> 'required',
            'brand_id'=> 'required',
            'qty'=> 'required',
            'category'=> 'required|numeric',
            'is_featured'=> 'required|in:Yes,No',

     ]);
     if( $validator->passes()){
        $producs = new Product();
        $producs->title = $request->title;
        $producs->slug = $request->slug;
        $producs->description = $request->description;
        $producs->short_description = $request->short_description;
        $producs->shipping_returns = $request->shipping_returns;
        $producs->price = $request->price;
        $producs->compare_price = $request->compare_price;
        $producs->category_id = $request->category;
        $producs->sub_category_id = $request->sub_category;
        $producs->brand_id = $request->brand_id;
        $producs->is_featured = $request->is_featured;
        $producs->related_products = (!empty($request->related_products)) ? implode(',',$request->related_products) : '';
        $producs->sku = $request->sku;
        $producs->barcode = $request->barcode;
        $producs->track_qty = $request->track_qty;
        $producs->qty = $request->qty;
        $producs->status = $request->status;
        $producs->save();

        if(!empty($request->array_image)){
          foreach($request->array_image as $temp_image_id)
          {
           $tempImageInfo = TempImage::find($temp_image_id);
           $extArray = explode('.', $tempImageInfo->name);
           $ext = last($extArray);
           $ProductImage = new ProductImage();
           $ProductImage->product_id =  $producs->id;
           $ProductImage->image = 'NULL';
           $ProductImage->save();

           $imageName = $producs->id.'-'.$ProductImage->id.'-'.time().'.'.$ext;
           $ProductImage->image = $imageName;
           $ProductImage->save();

           //Create image Gallery//

            //Large Image//
             $sourcePath = public_path().'/temp/'.$tempImageInfo->name;
             $destPath = public_path().'/uploads/product/large/'.$imageName;
             $manager = new ImageManager(new Driver());
              $image = $manager->read($sourcePath);
              $image->scaleDown(1400);
              $image->save($destPath);

              //Small image//
              $destPath = public_path().'/uploads/product/small/'.$imageName;
              $image = $manager->read($sourcePath);
              $image->cover(300, 300);
              $image->save($destPath);
          }
        }

        $request->session()->flash('success','Product added successfully');
            return response()->json([
                'status' => true,
                'message' => 'Product added successfully'
              ]);
     }else{
        return response()->json([
            'status' => false,
            'errors' => $validator->errors()
        ]);
     }
   }

   public function edit($product_ID, Request $request)
   {

      $relatedProduct = [];
        $data = [];
        $product = Product::find($product_ID);
        if(empty($product)){
        return redirect()->route('products.index')->with('error','Product not found');
        }
        $ProductImage = ProductImage::where('product_id',$product->id)->get();

        if($product->related_products !=''){
        $productArray = explode(',', $product->related_products);
        $relatedProduct = Product::whereIn('id',$productArray)->get();
        }

        $subcategories = SubCategory::where('category_id',$product->category_id)->get();
        $categories = Category::orderBy('name','ASC')->get();
        $brands = Brands::orderBy('name','ASC')->get();
        $data['categories'] = $categories;
        $data['subcategories'] = $subcategories;
        $data['brands'] = $brands;
        $data['product'] = $product;
        $data['ProductImage'] = $ProductImage;
        $data['relatedProduct'] = $relatedProduct;
        return view('admin.products.edit',$data);
   }

   public function update($id, Request $request)
   {
    $product = Product::find($id);
    $rules = [
      'title'=>'required',
      'slug'=>'required|unique:products,slug,'.$product->id.',id',
      'price'=> 'required|numeric',
      'barcode'=> 'required',
      'brand_id'=> 'required',
      'track_qty'=> 'required|in:Yes,No',
      'sku'=>'required|unique:products,sku,'.$product->id.',id',
      'category'=> 'required|numeric',
      'is_featured'=> 'required|in:Yes,No',
      ];

      if(!empty($request->track_qty) && $request->track_qty == 'Yes')
      {
        $rules['qty'] = 'required|numeric';
      }

      $validator = Validator::make($request->all(),$rules);
      if( $validator->passes())
      {
          $product->title = $request->title;
          $product->slug = $request->slug;
          $product->short_description = $request->short_description;
          $product->description = $request->description;
          $product->shipping_returns = $request->shipping_returns;
          $product->price = $request->price;
          $product->compare_price = $request->compare_price;
          $product->category_id = $request->category;
          $product->sub_category_id = $request->sub_category;
          $product->brand_id = $request->brand_id;
          $product->is_featured = $request->is_featured;
          $product->related_products = (!empty($request->related_products)) ? implode(',',$request->related_products) : '';
          $product->sku = $request->sku;
          $product->barcode = $request->barcode;
          $product->track_qty = $request->track_qty;
          $product->qty = $request->qty;
          $product->status = $request->status;
          $product->save();
          $request->session()->flash('success','Product Update successfully');
              return response()->json([
                  'status' => true,
                  'message' => 'Product Update successfully'
                ]);
        }else{
          return response()->json([
              'status' => false,
              'errors' => $validator->errors()
          ]);
      }
   }

   public function destroy($pid, Request $request){
    $product = Product::find($pid);
    if (empty($product)){
      $request->session()->flash('error','Product not found');
        return response()->json([
        'status' => false,
        'notFound' => true
    ]);
    }
    $ProductImages = ProductImage::where('product_id',$pid)->get();
    if (!empty($ProductImages)){
      foreach($ProductImages as $ProductImage)
      {
       File::delete(public_path('uploads/proudct/small/'.$ProductImage->image));
       File::delete(public_path('uploads/proudct/large/'.$ProductImage->image));
      }
      ProductImage::where('product_id',$pid)->delete();
    }

    $product->delete();
    $request->session()->flash('success','Product Deleted successfully');
              return response()->json([
                  'status' => true,
                  'message' => 'Product Deleted successfully'
                ]);

   }

   public function getProducts(Request $request){
    if($request->term != ""){
     $relatedProduct = Product::where('title','like','%'.$request->term.'%')->get();
     if($relatedProduct != null){
      foreach($relatedProduct as $product){
        $tempProduct[] = array('id'=>$product->id, 'text'=>$product->title);
       }
      }
    }
    return response()->json([
                'tags' => $tempProduct,
                'status' => true
             ]);
   }


   public function productRating(Request $request){
    $ratings = ProductRating::select('product_ratings.*','products.title as productTitle')->orderBy('created_at','DESC');
    $ratings = $ratings->leftJoin('products','products.id','product_ratings.product_id');
    if($request->get('keyword') != ""){
        $ratings = $ratings->orWhere('product_ratings.username','like','%'.$request->keyword.'%');
        $ratings = $ratings->orWhere('products.title','like','%'.$request->keyword.'%');
      }
    $ratings = $ratings->paginate(10);
    return view('admin.products.ratings',['ratings'=>$ratings]);
   }


  public function updateProductRating(Request $request){
    if($request->status !='' && $request->ratingId !=''){
        ProductRating::where('id',$request->ratingId)->update(['status'=>$request->status]);
        session()->flash('success','Rating update successfully.');
        return response()->json([
            'status'=>true,
        ]);
    }
  }

}

