<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\Brands;
use App\Models\Product;
use App\Models\ProductRating;
use Illuminate\Support\Facades\Validator;


class ShopController extends Controller
{


   public function index(Request $request, $categorySlug = null, $subCategorySlug = null)
   {
    $data = [];
    $categorySelected ='';
    $subcategorySelected ='';
    $brandArray = [];
    if(!empty($request->get('brand'))){
      $brandArray = explode(',', $request->get('brand'));
    }

    $categories = Category::orderBy('name','ASC')->with('sub_categories')->where('showHome','Yes')->where('status','1')->get();
    $brands = Brands::orderBy('name','ASC')->where('status','1')->get();
    $products = Product::where('status','1');

    // Apply filter//

    if(!empty($categorySlug)){
         $Category = Category::where('slug',$categorySlug)->first();
         $products = $products->where('category_id',$Category->id);
         $categorySelected = $Category->id;
    }

    if(!empty($subCategorySlug)){
      $SubCategory = SubCategory::where('slug',$subCategorySlug)->first();
      $products = $products->where('sub_category_id',$SubCategory->id);
      $subcategorySelected = $SubCategory->id;
 }

 if(!empty($request->get('brand'))){
   $brandArray = explode(',', $request->get('brand'));

   $products = $products->whereIn('brand_id',$brandArray);
 }
 if($request->get('min_price') !="" && $request->get('max_price') !=""){
   $min_price = intval($request->get('min_price'));
   $max_price = intval($request->get('max_price'));
   if(intval($request->get('max_price')) == 50000){
      $products = $products->whereBetween('price',[$min_price, 100000]);
   }
   else{
     $products = $products->whereBetween('price',[$min_price, $max_price]);
   }
 }

 if(!empty($request->get('search'))){
    $products = $products->where('title','like','%'.$request->get('search').'%');
 }


 if($request->get('sort')){
    if($request->get('sort') == 'latest'){
      $products = $products->orderBy('price','DESC');
    }
    else if($request->get('sort') == 'price_desc'){
      $products = $products->orderBy('price','DESC');
    }
    else {
      $products = $products->orderBy('id','ASC');

    }
 }
 else{
      $products = $products->orderBy('id','DESC');
 }


    $products = $products->paginate(6)->withQueryString();
    $data['categories'] = $categories;
    $data['brands'] = $brands;
    $data['products'] = $products;
    $data['categorySelected'] = $categorySelected;
    $data['subcategorySelected'] = $subcategorySelected;
    $data['brandArray'] = $brandArray;
    $data['maxPrice'] = (intval($request->get('max_price')==0)) ? 50000 : intval($request->get('max_price'));
    $data['minPrice'] = intval($request->get('min_price'));
    $data['sort'] = $request->get('sort');
    return view('front.shop',$data);
   }


   public function product($slug){
        $product = Product::where('slug',$slug)
        ->withCount('product_rating')
        ->withSum('product_rating','rating')
        ->with('product_image')->first();

        if($product == NULL){
        abort(404);
        }
     //Rating calculation//
       $avgRating = '0.00';
       $avgRatingPer = 0;
       if($product->product_rating_count >0 ){
           $avgRating = number_format(($product->product_rating_sum_rating/$product->product_rating_count),2);
           $avgRatingPer = ($avgRating*100)/5;
       }

    //related product
        $relatedProduct = [];
        if($product->related_products != ''){
        $relatedArray = explode(',', $product->related_products);
        $relatedProduct = Product::whereIn('id',$relatedArray)->where('status',1)->with('product_image')->get();
        }
        $data['product'] = $product;
        $data['relatedProduct'] = $relatedProduct;
        $data['avgRating'] = $avgRating;
        $data['avgRatingPer'] = $avgRatingPer;
        return view('front.product', $data);
      }

      public function saveProductRating($pid, Request $request){
        $validator = Validator::make($request->all(),[
          'username'=>'required',
          'email'=>'required|email',
          'comment'=>'required',
          'rating'=>'required',
        ]);

        if($validator->passes()){
            $productRating = new ProductRating();
            $check = $productRating->where('email',$request->email)->count();
            if($check >0){
                session()->flash('error','You have already rated this product.');
                return response()->json([
                    'status'=>true,
                   ]);
            }
           $productRating->username = $request->username;
           $productRating->email = $request->email;
           $productRating->product_id = $pid;
           $productRating->rating = $request->rating;
           $productRating->comment = $request->comment;
           $productRating->status = 0;
           $productRating->save();
           session()->flash('success','Product rating save successfully.');
           return response()->json([
            'status'=>true,
           ]);
        }
        else{
           return response()->json([
            'status'=>false,
            'errors'=>$validator->errors(),
           ]);
        }

      }
}
