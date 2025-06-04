<?php

namespace App\Http\Controllers\admin;
use App\Models\Page;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PageController extends Controller
{
    public function index(Request $request){
        $pages = Page::latest();
        if($request->get('searchkey')){
            $pages =  $pages->where('name','LIKE','%'.$request->get('searchkey').'%');
        }
        if($request->get('searchkey')){
            $pages =  $pages->orWhere('slug','LIKE','%'.$request->get('searchkey').'%');
        }

        $pages = $pages->paginate(10);

      return view('admin.pages.list',['pages'=>$pages]);
    }

    public function create(){
        return view('admin.pages.create');
    }

    public function store(Request $request){
        $Page = new Page();
        $validator = Validator::make($request->all(),[
            'name'=>'required',
            'slug'=>'required|unique:pages,slug',
            'content'=>'required',
        ]);

       if($validator->passes()){
            $Page->name = $request->name;
            $Page->slug = $request->slug;
            $Page->content = $request->content;
            $Page->save();
            session()->flash('success','Page created successfully');
            return response()->json([
                'status'=>true,
                'message' =>'Page created successfully',
            ]);
       }
       else{
        return response()->json([
            'status'=>false,
            'errors' =>$validator->errors(),
        ]);
       }
    }

    public function update($pageId){
        $page = Page::where('id',$pageId)->first();
        return view('admin.pages.edit',['page'=>$page]);
    }

    public function edit(Request $request,$pageId){
        $Page = Page::find($pageId);

        $validator = Validator::make($request->all(),[
            'name'=>'required',
            'slug'=>'required|unique:pages,slug,'.$pageId.',id',
            'content'=>'required',
        ]);

       if($validator->passes()){
            $Page->name = $request->name;
            $Page->slug = $request->slug;
            $Page->content = $request->content;
            $Page->status = $request->status;
            $Page->save();
            session()->flash('success','Page Update successfully');
            return response()->json([
                'status'=>true,
                'message' =>'Page Update successfully',
            ]);
       }
       else{
        return response()->json([
            'status'=>false,
            'errors' =>$validator->errors(),
        ]);
       }

    }


    public function destroy($pageId){
        $Page = Page::find($pageId);
        if($Page == NULL){
            session()->flash('success','Page Not Found!!');
            return response()->json([
                'status'=>true,
            ]);
        }
        else{
            $Page->delete();
            session()->flash('success','Page Delete Successfully.');
            return response()->json([
                'status'=>true,
            ]);
        }
    }
}
