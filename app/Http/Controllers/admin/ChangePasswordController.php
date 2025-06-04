<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class ChangePasswordController extends Controller
{
    public function index(){
        return view('admin.settings.change-password');
    }

    public function updatePassword(Request $request){
        $id = Auth::guard('admin')->user()->id;

      $Validator = Validator::make($request->all(),[
        'old_password'=>'required',
        'new_password'=>'required|min:5',
        'confirm_password'=>'required|same:new_password',
       ]);

       if($Validator->passes()){
         $user = User::select('id','password')->where('id',$id)->first();
        if(!Hash::check($request->old_password, $user->password)){
            $errors['old_password'] = 'Old password is not valide';
            return response()->json([
                'status'=>false,
                'errors'=>$errors,
                ]);
             }
             User::where('id',$id)->update([
                'password'=> Hash::make($request->new_password)
             ]);
             session()->flash('success','Password Update successfully.');
             return response()->json([
                'status'=>true,
                ]);

       }
       else{
        return response()->json([
            'status'=>false,
            'errors'=>$Validator->errors(),
            ]);
       }
    }

}
