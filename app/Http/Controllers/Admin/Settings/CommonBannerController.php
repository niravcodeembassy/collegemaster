<?php

namespace App\Http\Controllers\Admin\Settings;

use Aj\FileUploader\FileUploader;
use App\Category;
use App\Http\Controllers\Controller;
use App\Model\CommonBanner;
use App\Traits\DatatableTrait;
use Illuminate\Http\Request;

class CommonBannerController extends Controller
{
    use DatatableTrait;
    public function index()
    {
        $this->data['title'] = 'Banner';
        $this->data['commonBanner'] = CommonBanner::whereNull('is_active')->get();
        return $this->view('admin.settings.commonbanner.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        foreach ($request->caption1 as $key => $value) {
            $banner = CommonBanner::find($request->input('id.' . $key));
            $banner->caption1 = $request->input('caption1.' . $key);
            $banner->caption2 = $request->input('caption2.' . $key);
            $banner->caption3 = $request->input('caption3.' . $key);
            $banner->url = $request->input('url.' . $key);
            $banner->is_active = $request->input('is_active.' . $key) != "1" ? date('Y-m-d H:i:s', time())  : null;
            $file = FileUploader::make($request->file('banner_image_' . $key, null))->upload('banner', $banner->image ?? null);
            $banner->image = $file;
            $banner->save();
        }

        return back()->with('success', 'Common banner Created Successfully');
    }
}
