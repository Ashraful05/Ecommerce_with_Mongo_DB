<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Auth;
use Hash;
use Intervention\Image\Facades\Image;

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
        if($request->isMethod('post')){
            if(Hash::check($request->current_password,Auth::guard('admin')->user()->password)){
                if($request->new_password == $request->confirm_password){
                    Admin::where('email',Auth::guard('admin')->user()->email)->update(['password'=>Hash::make($request->new_password)]);
                    $notification = [
                        'alert-type'=>'success',
                        'message'=>'Password is Changed Successfully!'
                    ];
                    return redirect()->back()->with($notification);
                }else{
                    $notification = [
                        'alert-type'=>'error',
                        'message'=>'New and Old Password does not match!'
                    ];
                    return redirect()->back()->with($notification);
                }


            }else{
                $notification = [
                    'alert-type'=>'error',
                    'message'=>'Incorrect Current Password!'
                ];
                return redirect()->back()->with($notification);
            }
        }
        return view('admin.update_password');
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
    public function updateAdminDetails(Request $request)
    {
        if($request->isMethod('post')){

            $request->validate([
//                'name'=>'required|alpha',
                'name'=>'required',
                'mobile'=>'required|numeric'
            ],[
//                'name.alpha'=>'Valid name is required',
                'mobile.numeric'=>'Valid mobile is required'
            ]);

            if($request->hasFile('image')){
                $image = $request->file('image');
                @unlink(public_path('admin/images/photos/'.Auth::guard('admin')->user()->image));
                if($image->isValid()){
                    $imageName = rand(111,99999).'.'.$image->getClientOriginalExtension();
                    $imagePath = 'admin/images/photos/'.$imageName;
                    Image::make($image)->save($imagePath);
                }
                Admin::where('email',Auth::guard('admin')->user()->email)->update(['name'=>$request->name,
                    'mobile'=>$request->mobile,'image'=>$imageName]);
                $notification = [
                    'alert-type'=>'success',
                    'message'=>'Admin Info updated!!'
                ];
                return redirect()->back()->with($notification);

            }else{
                Admin::where('email',Auth::guard('admin')->user()->email)->update(['name'=>$request->name,
                    'mobile'=>$request->mobile]);
                $notification = [
                    'alert-type'=>'success',
                    'message'=>'Admin Info updated!!'
                ];
                return redirect()->back()->with($notification);
            }
//elseif (!empty($request->current_image)){
//                $imageName = $request->current_image;
//            }else{
//                $imageName = '';
//            }

//            Admin::where('email',Auth::guard('admin')->user()->email)->update(['name'=>$request->name,
//                'mobile'=>$request->mobile,'image'=>$imageName]);
//            $notification = [
//                'alert-type'=>'success',
//                'message'=>'Admin Info updated!!'
//            ];
//            return redirect()->back()->with($notification);
//        }


        }
        return view('admin.update_admin_details');
    }
}
