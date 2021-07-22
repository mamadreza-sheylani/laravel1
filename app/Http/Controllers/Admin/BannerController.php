<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;

class BannerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $banners = Banner::latest()->paginate(20);
        return view('admin.banners.index' , compact('banners'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.banners.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request , Banner $banner)
    {
        $request->validate([
            'banner_image' => 'required|mimes:png,jpg,jpeg',
            'banner_type' => 'required',
            'priority' => 'required|integer',
        ]);

        $fileNameBannerImage = generateFileName($request->banner_image->getClientOriginalName());
        $request->banner_image->move(public_path(env('PRODUCT_BANNER_IMAGES_UPLOAD_PATH')),$fileNameBannerImage);

        $banner->create([
            'image' => $fileNameBannerImage ,
            'type' => $request->banner_type ,
            'priority' => $request->priority,
            'title' => $request->title ,
            'text' => $request->text ,
            'is_active' => $request->is_active ,
            'button_text' => $request->button_text ,
            'button_link' => $request->button_link ,
            'button_icon' => $request->button_icon
        ]);

        alert()->success('You Uploaded A Image','Banner Image Uploaded Successfully')->persistent('OK');
        return redirect()->route('admin.banners.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Banner $banner)
    {
        return view('admin.banners.show' , compact('banner'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Banner $banner)
    {
        return view('admin.banners.edit' , compact('banner'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Banner $banner)
    {
        $request->validate([
            'banner_image' => 'nullable|mimes:png,jpg,jpeg',
            'banner_type' => 'required',
            'priority' => 'required|integer',
        ]);

        if ($request->has('banner_image')) {
            $fileNameBannerImage = generateFileName($request->banner_image->getClientOriginalName());
            $request->banner_image->move(public_path(env('PRODUCT_BANNER_IMAGES_UPLOAD_PATH')),$fileNameBannerImage);

        }

        $banner->update([
            'image' => $request->has('banner_image') ? $fileNameBannerImage : $banner->image ,
            'type' => $request->banner_type ,
            'priority' => $request->priority,
            'title' => $request->title ,
            'text' => $request->text ,
            'is_active' => $request->is_active ,
            'button_text' => $request->button_text ,
            'button_link' => $request->button_link ,
            'button_icon' => $request->button_icon
        ]);

        alert()->success('You Updated A Banner','Banner Image Updated Successfully')->persistent('OK');
        return redirect()->route('admin.banners.index');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Banner $banner)
    {
        $banner->delete();
        alert()->success('You Deleted A Banner' , 'Banner Deleted Successfully.')->persistent('OK');
        return redirect()->route('admin.banners.index');
    }
}
