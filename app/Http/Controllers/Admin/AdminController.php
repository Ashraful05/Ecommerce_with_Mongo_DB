<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\AdminRole;
use Illuminate\Http\Request;
//use Auth;
use Hash;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;
use mysql_xdevapi\CollectionModify;

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
            if(Auth::guard('admin')->attempt(['email'=>$request->email,'password'=>$request->password,'status'=>1])){

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
        }
        return view('admin.update_admin_details');
    }
    public function subAdmin()
    {
        $subAdmins = Admin::where('type','subadmin')->get();
//        return $subAdmins;
        return view('admin.subadmins.subadmin',compact('subAdmins'));
    }

    public function updateSubAdminPageStatus(Request $request){
        if($request->status == 'active'){
            $status = 0;
        }else{
            $status = 1;
        }
        Admin::where('_id',$request->page_id)->update(['status'=>$status]);

        return response()->json(['status'=>$status,'page_id'=>$request->page_id]);
    }
    public function deleteSubAdmin($id)
    {
        $subAdminData = Admin::findOrFail($id);


        @unlink(public_path('admin/images/sub_admin_photos/'.$subAdminData->image));
        $subAdminData->delete();

        $notification = [
            'alert-type'=>'error',
            'message'=>'Sub Admin Info deleted!!'
        ];
        return redirect()->back()->with($notification);
    }

    public function addSubAdmin()
    {
        return view('admin.subadmins.add_sub_admin');
    }
    public function saveSubAdmin(Request $request)
    {
        $request->validate([
//                'name'=>'required|alpha',
            'name'=>'required',
            'mobile'=>'required|numeric',
            'image'=>'required|image|mimes:jpg,jpeg,png,gif,webp',
            'email'=>'required|unique:admins'
        ],[
            'mobile.numeric'=>'Valid mobile is required',
            'email.required'=>'Unique email is required',
        ]);

        if($request->hasFile('image')){
            $image = $request->file('image');
            if($image->isValid()){
                $imageName = rand(111,99999).'.'.$image->getClientOriginalExtension();

                $imagePath = public_path('admin/images/sub_admin_photos/'.$imageName);

                Image::make($image)->save($imagePath);
            }
        }
        Admin::create([
           'name'=>$request->name,
           'email'=>$request->email,
           'mobile'=>$request->mobile,
           'password'=>Hash::make($request->password),
            'image'=>$imageName,
            'status'=>1,
            'type'=>'subadmin'
        ]);
        $notification = [
            'alert-type'=>'success',
            'message'=>'Admin Info updated!!'
        ];
        return redirect()->route('subadmins')->with($notification);
    }

    public function editSubAdmin($id)
    {
        $subAdminData = Auth::guard('admin')->user()->find($id);
        return view('admin.subadmins.edit_sub_admin',compact('subAdminData'));
    }
    public function updateSubAdminData(Request $request,$id)
    {
//        return $request->all();
        $adminData = Auth::guard('admin')->user()->find($id);
        $request->validate([
            'name'=>'required',
            'mobile'=>'required|numeric',
        ],[
            'mobile.numeric'=>'Valid mobile is required',
        ]);
        if ($request->hasFile('image')) {
            if(!empty($request->old_image)){
                @unlink(public_path('admin/images/sub_admin_photos/'.$adminData->image));
            }
            $image = $request->file('image');
            if ($image->isValid()) {
                $imageName = rand(111, 99999).'.'.$image->getClientOriginalExtension();
                $imagePath = public_path('admin/images/sub_admin_photos/'.$imageName);
                Image::make($image)->save($imagePath);
            }
            $adminData->update([
                'name'=>$request->name,
                'mobile'=>$request->mobile,
                'password'=>Hash::make($request->password),
                'image'=>$imageName,
                'status'=>1,
                'type'=>'subadmin'
            ]);
        }else{
            $adminData->update([
                'name'=>$request->name,
                'mobile'=>$request->mobile,
                'password'=>Hash::make($request->password),
                'status'=>1,
                'type'=>'subadmin'
            ]);
        }

        $notification = [
            'alert-type'=>'info',
            'message'=>'Sub Admin Info updated!!'
        ];
        return redirect()->route('subadmins')->with($notification);
    }

    public function updateAdminRole(Request $request,$id)
    {
        if($request->isMethod('post')){
           $data = $request->all();
//           return $data;
//            if(isset($data['cms_pages']['view'])){
//                $cms_pages_view = $data['cms_pages']['view'];
//            }else{
//                $cms_pages_view = 0;
//            }
//            if(isset($data['cms_pages']['edit'])){
//                $cms_pages_edit = $data['cms_pages']['edit'];
//            }else{
//                $cms_pages_edit = 0;
//            }
//            if(isset($data['cms_pages']['full'])){
//                $cms_pages_full = $data['cms_pages']['full'];
//            }else{
//                $cms_pages_full = 0;
//            }

            AdminRole::where('admin_id',$data['admin_id'])->delete();

            foreach ($data as $key => $value){
                if(isset($value['view'])){
                    $view = $value['view'];
                }else{
                    $view = 0;
                }
                if(isset($value['edit'])){
                    $edit = $value['edit'];
                }else{
                    $edit = 0;
                }
                if(isset($value['full'])){
                    $full = $value['full'];
                }else{
                    $full = 0;
                }
            }

            $adminRoleCount = AdminRole::where('admin_id',$data['admin_id'])->count();

            if($adminRoleCount>0){
                AdminRole::where('admin_id',$data['admin_id'])->update([
                    'module'=>$key,
                    'view_access'=>$view,
                    'edit_access'=>$edit,
                    'full_access'=>$full,
                ]);
            }else{
                AdminRole::create([
                   'admin_id'=>$data['admin_id'],
                    'module'=>$key,
                    'view_access'=>$view,
                    'edit_access'=>$edit,
                    'full_access'=>$full
                ]);
            }
            $notification = [
              'alert-type'=>'info',
              'message'=>'Sub Admin Roles Updated!!'
            ];
            return redirect()->back()->with($notification);
        }
        $subAdminRoles = AdminRole::where('admin_id',$id)->get();
//        return $subAdminRoles;
        $subAdminDetails = Admin::where('_id',$id)->first();

        $title = 'Update '.$subAdminDetails->name.' Sub Admin Roles/Permissions';

        return view('admin.subadmins.update_admin_role',compact('subAdminRoles','subAdminDetails','title','id'));
    }

}
