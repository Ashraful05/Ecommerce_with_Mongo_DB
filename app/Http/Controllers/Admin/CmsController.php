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
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CmsPage $cmsPage)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CmsPage $cmsPage)
    {
        //
    }
}
