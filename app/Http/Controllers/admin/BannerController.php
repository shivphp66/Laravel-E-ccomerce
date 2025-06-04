<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Banner;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManager;
use App\Models\TempImage;
use Intervention\Image\Drivers\Gd\Driver;

class BannerController extends Controller
{
    public function index(Request $request){

     $banners = Banner::orderBy('created_at','DESC');
     if($request->get('keyword')){
        $banners= $banners->where('title','LIKE','%'.$request->get('keyword').'%');
     }
     $banners= $banners->paginate(10);
     return view('admin.banners.list',['banners'=>$banners]);
    }

    public function create(){
        return view('admin.banners.create');
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(),[
            'title'=>'required',
            'content'=>'required',
        ]);

        if($validator->passes()){
            $banner = new Banner();
            $banner->title = $request->title;
            $banner->content = $request->content;
            $banner->status = $request->status;
            $banner->save();

             if(!empty($request->banner_image)){
                $TempImage = TempImage::find($request->banner_image);
                $extArray = explode('.',$TempImage->name);
                $ext = last($extArray);
                $newImgeName = $banner->id.'_'.time().'.'.$ext;
                $sPath = public_path().'/temp/'.$TempImage->name;
                $dPath = public_path().'/uploads/banner/'.$newImgeName;
                FILE::copy($sPath,$dPath);
                $dPath = public_path().'/uploads/banner/'.$newImgeName;
                $manager = new ImageManager(new Driver());
                $image = $manager->read($sPath);
                $image->scaleDown(1919,752);
                $image->save($dPath);
                $banner->banner_image =  $newImgeName;

            //Medium image//
               $mediumImage = 'm_'.time().'.'.$ext;
                $dPath = public_path().'/uploads/banner/'.$mediumImage;
                $mimage = $manager->read($sPath);
                $mimage->scaleDown(650,750);
                $mimage->save($dPath);

                $banner->m_image = $mediumImage;
                $banner->save();

              }

              $request->session()->flash('success','Banner added successfully');
              return response()->json([
               'status' => true,
               'message' => 'Banner added successfully'
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
        $banner = Banner::where('id',$id)->first();
        return view('admin.banners.edit',['banner'=>$banner]);
    }

    public function update($id,Request $request){
        $banner = Banner::find($id);

        $validator = Validator::make($request->all(),[
            'title'=>'required',
            'content'=>'required',
        ]);

        if($validator->passes()){

            $banner->title = $request->title;
            $banner->content = $request->content;
            $banner->status = $request->status;
            $banner->save();

             $oldBanner = $banner->banner_image;
             $oldMedium = $banner->m_image;

             if(!empty($request->banner_image)){
                $TempImage = TempImage::find($request->banner_image);
                $extArray = explode('.',$TempImage->name);
                $ext = last($extArray);
                $newImgeName = $banner->id.'_'.time().'.'.$ext;
                $sPath = public_path().'/temp/'.$TempImage->name;
                $dPath = public_path().'/uploads/banner/large/'.$newImgeName;
                FILE::copy($sPath,$dPath);
                $dPath = public_path().'/uploads/banner/large/'.$newImgeName;
                $manager = new ImageManager(new Driver());
                $image = $manager->read($sPath);
                $image->scaleDown(1919,752);
                $image->save($dPath);
                $banner->banner_image =  $newImgeName;

            //Medium image//
                $mediumImage = 'm_'.time().'.'.$ext;
                $dPath = public_path().'/uploads/banner/small/'.$mediumImage;
                $mimage = $manager->read($sPath);
                $mimage->scaleDown(650,750);
                $mimage->save($dPath);

                $banner->m_image = $mediumImage;
                $banner->save();
                File::delete( public_path().'/uploads/banner/large/'.$oldBanner);
                File::delete( public_path().'/uploads/banner/small/'.$oldMedium);

              }

              $request->session()->flash('success','Banner update successfully');
              return response()->json([
               'status' => true,
               'message' => 'Banner update successfully'
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


