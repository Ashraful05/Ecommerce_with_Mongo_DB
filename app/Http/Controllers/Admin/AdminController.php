<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Auth;
use Hash;

class AdminController extends Controller
{
    public function index()
    {
        return view('admin.layout.home');
    }
    public function logIn(Request $request)
    {
        if($request->isMethod('post')){
//            return $request->all();
            $request->validate([
                'email'=>'required|email|max:255',
                'password'=>'required|min:4'
            ],[
                'email.email'=>'Valid email is required'
            ]);
            if(Auth::guard('admin')->attempt(['email'=>$request->email,'password'=>$request->password])){

                if(!empty($_post['remember_me'])){
                    setcookie(['email',$_post['email']],time()+3600);
                    setcookie(['password',$_post['password'],time()+3600]);
                }else{
                    setcookie('email','');
                    setcookie('password','');
                }
                $notification = [
                    'alert-type'=>'success',
                    'message'=>'Successfully LoggedIn!'
                ];
                return redirect()->route('admin.home')->with($notification);
            }else{
                $notification = [
                    'alert-type'=>'error',
                    'message'=>'Invalid email or password!'
                ];
                return redirect()->back()->with($notification);
            }
        }
        return view('admin.login');
    }
    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect()->route('admin.login');
    }

    public function updatePassword(Request $request){
//        $adminData = Admin::get();
        return view('admin.update_password');
        if($request->isMethod('post')){

        }
    }
    public function passwordCheckUsingAjax(Request $request)
    {
        if(Hash::check($request->current_password,Auth::guard('admin')->user()->password ) )
        {
            return "true";
        }
        else{
            return "false";
        }
    }
}
