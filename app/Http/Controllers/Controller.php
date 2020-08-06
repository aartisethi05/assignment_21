<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use App\User;
use Crypt;
class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function recover_password(Request $request){
        $email = $request->input('email');
        $password = User::where('email',$email)->value('password');  
        if($password!=null)
         return json_encode([$password=>Crypt::decrypt($password),$original=>$password]);  
        else
         return false;
    }
    public function change_password(Request $request){
        $email = $request->input('email');
        $password = $request->input('password');
        if(User::where('email',$email)->update(['password'=>Crypt::encrypt($password)])) 
         return true;
        else
         return false;
    }

    public function insertRow(){
        // DB::table('users')->insert(
        //     ['email' => 'aarti@example.com', 'password' => 'aarti123']
        // );
        $user = new User;
        $user->name = 'aarti';
        $user->created_at = '2019-04-02 15:25:37';
        $user->updated_at = '2019-04-02 15:25:37';
        $user->email_verified_at = '2019-04-02 15:25:37';
        $user->remember_token = 'aarti';
$user->email = 'test@gmail.com';
$user->id =21 ;
$user->password = Crypt::encrypt('aarti123');
$user->save();
    }
}
