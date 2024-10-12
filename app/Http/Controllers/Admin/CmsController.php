<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CmsPage;
use Illuminate\Http\Request;

class CmsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cmsPages = CmsPage::get();
        return view('admin.pages.cms_page',compact('cmsPages'));
    }

    public function updateCmsPageStatus(Request $request){
        if($request->status == 'active'){
            $status = 0;
        }else{
            $status = 1;
        }
        CmsPage::where('_id',$request->page_id)->update(['status'=>$status]);

        return response()->json(['status'=>$status,'page_id'=>$request->page_id]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(CmsPage $cmsPage)
    {
        return view('admin.pages.form',compact('cmsPage'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
           'title'=>'required',
           'url'=>'required'
        ]);
        CmsPage::create([
            'title'=>$request->title,
            'url'=>$request->url,
            'description'=>$request->description,
            'status'=>1
        ]);
        $notification = [
          'alert-type'=>'success',
          'message'=>'Page Created Successfully!!'
        ];
        return redirect()->route('cmsPage.index')->with($notification);
    }

    /**
     * Display the specified resource.
     */
    public function show(CmsPage $cmsPage)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CmsPage $cmsPage)
    {
        return view('admin.pages.form',compact('cmsPage'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CmsPage $cmsPage)
    {
        $request->validate([
            'title'=>'required',
            'url'=>'required'
        ]);
        $cmsPage->update($request->all());
        $notification = [
            'alert-type'=>'info',
            'message'=>'Page Updated Successfully!!'
        ];
        return redirect()->route('cmsPage.index')->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     */
//    public function destroy(CmsPage $cmsPage)
    public function destroy($id)
    {
        CmsPage::destroy($id);

        $notification = [
            'alert-type'=>'error',
            'message'=>'cms page deleted'
        ];
        return redirect()->back()->with($notification);
    }

//    public function destroy(Request $request){
//        CmsPage::find($request->id)->delete();
//        $notification = [
//            'alert-type'=>'error',
//            'message'=>'cms page deleted'
//        ];
//        return redirect()->back()->with($notification);
//    }
}
