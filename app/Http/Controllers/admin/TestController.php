<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\CustomerAadress;

class TestController extends Controller
{
   public function checkQueryFunction(){
     $users = User::with('oneAddress')->get();
      echo'<pre>'; print_r($users->toArray());
   }
}
