<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use App\Models\ProductImage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class ProductImageController extends Controller
{
    public function update(Request $request)
    {
            $image = $request->image;
            $ext = $image->getClientOriginalExtension();
            $sourcePath = $image->getPathName();
            $ProductImage = new ProductImage();
            $ProductImage->product_id =  $request->product_id;
            $ProductImage->image = 'NULL';
            $ProductImage->save();

             $imageName = $request->product_id.'-'.$ProductImage->id.'-'.time().'.'.$ext;
             $ProductImage->image = $imageName;
             $ProductImage->save();

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

            $request->session()->flash('success','Product Image Update successfully');
            return response()->json([
                'status' => true,
                'image_id' => $ProductImage->id,
                'ImagePath' => asset('uploads/product/small/'.$ProductImage->image),
                'message' => 'Product Image Update successfully'
              ]);
    }

    function destroy(Request $request)
    {
        $productImge = ProductImage::find($request->id);

        if(empty($productImge)){
            return response()->json([
                'status' => false,
                'message' => 'Product Image not found!'
              ]);
        }
        File::delete(public_path('uploads/product/small/'.$productImge->image));
        File::delete(public_path('uploads/product/large/'.$productImge->image));
        $productImge->delete();
        $request->session()->flash('success','Product Image Delete successfully');
            return response()->json([
                'status' => true,
                'message' => 'Product Image Delete successfully'
              ]);

    }
}
