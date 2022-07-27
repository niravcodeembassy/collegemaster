<?php

namespace App\Http\Controllers\Admin\Settings;

use Carbon\Carbon;
use App\Model\DealOfDay;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DealOfDayController extends Controller
{
    public function index()
    {
        $day_of_deal = DealOfDay::first();

        return view('admin.settings.dealofday.index',compact('day_of_deal'));
    }

    public function update(Request $request){

        $day_of_deal = DealOfDay::find($request->id);

        $date=date_create($request->end_date);
        $date= date_format($date,"Y/m/d H:i:s");
        $start_date = Carbon::parse($request->start_date)->format('Y-m-d h:i:s');
        $end_date = Carbon::parse($date)->format('Y-m-d h:i:s');
        
        $param = array();

        $param['title'] = $request->title;
        $param['btn_name'] = $request->button_name;
        $param['btn_url'] = $request->button_url;
        $param['product_id'] = $request->deal_product;
        $param['status'] = $request->status;
        // $param['start_time'] = $start_date;
        $param['end_time'] = $end_date;
        if ($request->hasFile('banner_image')) {
            $uploadfile =  $this->uploadFile($request->File('banner_image'));
            $param['bg_img'] = $uploadfile;
        }
        $day_of_deal->update($param);
        return redirect()->route('admin.dealofday.index')->with('success', "Deal Of Day Update");

    }

    public function uploadFile($value)
  {
    $file = $value;
    $fileName = time() . '_' . rand(0, 500) . '_' . $file->getClientOriginalName();
    $fileName = str_replace(' ', '_', $fileName);
    $uploadfile =  $file->storeAs('deal_banner', $fileName);
    return $uploadfile;
  }
    
}
