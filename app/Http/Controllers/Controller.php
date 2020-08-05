<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use App\User;
class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function recover_password(Request $request){
        $email = $request->input('email');
        $password = User::where('email',$email)->value('password');  
        if($password!=null)
         return json_encode($password);  
        else
         return false;
    }
    public function change_password(Request $request){
        $email = $request->input('email');
        $password = $request->input('password');
        if(User::where('email',$email)->update(['password'=>$password])) 
         return true;
        else
         return false;
    }
}
