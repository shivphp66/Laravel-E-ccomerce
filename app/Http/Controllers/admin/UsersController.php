<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
     public function index(Request $request){
        $users = User::latest();
        if($request->get('userSearch') !=''){
            $users = $users->where('name','LIKE','%'.$request->get('userSearch').'%')
            ->orWhere('email','LIKE','%'.$request->get('userSearch').'%')
            ->orWhere('phone','LIKE','%'.$request->get('userSearch').'%');
        }
        $users = $users->paginate(10);
        return view('admin.users.list',['users'=>$users]);
     }


     public function create(Request $request){
        return view('admin.users.create');
     }

     public function store(Request $request){
       $Validator = Validator::make($request->all(),[
            'name'=>'required',
            'email'=>'required|email|unique:users,email',
            'phone'=>'required',
            'password'=>'required',

         ]);

         if($Validator->passes()){
            $User = new User();
            $User->name = $request->name;
            $User->email = $request->email;
            $User->phone = $request->phone;
            $User->password = Hash::make($request->password);
            $User->status = $request->status;
            $User->save();

            session()->flash('success','Users save successfully');
             return response()->json([
                'status'=>true,
                'message'=>'Users save successfully',
             ]);
         }
         else{
               return response()->json([
                'status'=>false,
                'errors'=>$Validator->errors(),
                ]);
         }
     }

     public function update(Request $request,$id){
       $user = User::where('id',$id)->first();
       return view('admin.users.edit',['user'=>$user]);
     }

     public function edit(Request $request,$id){
        $User = User::find($id);

        $Validator = Validator::make($request->all(),[
             'name'=>'required',
             'email'=>'required|email|unique:users,email,'.$id.',id',
             'phone'=>'required',
          ]);

          if($Validator->passes()){
             $User->name = $request->name;
             $User->email = $request->email;
             $User->phone = $request->phone;
             $User->status = $request->status;
             $User->password = Hash::make($request->password);
             $User->save();

             session()->flash('success','Users Update successfully');
              return response()->json([
                 'status'=>true,
                 'message'=>'Users Update successfully',
              ]);
          }
          else{
                return response()->json([
                 'status'=>false,
                 'errors'=>$Validator->errors(),
                 ]);
          }
      }

      public function destroy($id){
        $User = User::find($id);
        if($User ==null){
            session()->flash('error','Users Not found!!');
            return response()->json([
               'status'=>true,
               'message'=>'Users Not found!!',
            ]);
        }
        $User->delete();
        session()->flash('success','Users Delete successfully');
              return response()->json([
                 'status'=>true,
                 'message'=>'Users Delete successfully',
              ]);
      }


}
