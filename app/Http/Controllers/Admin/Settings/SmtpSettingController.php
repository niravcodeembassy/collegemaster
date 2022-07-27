<?php

namespace App\Http\Controllers\Admin\Settings;

use App\Http\Controllers\Controller;
use App\Setting;
use Illuminate\Http\Request;

class SmtpSettingController extends Controller
{
    //

     //
     public function index() {
        $this->data['title'] = 'Smtp';
        $this->data['setting'] = Setting::where('name' ,'mail')->first();
        return $this->view('admin.settings.smtp');
    }

    public function store(Request $request) {

        $data = $request->all(); unset($data['_token']);

        $json = json_encode($data) ;

        Setting::updateOrCreate([
            'name' => 'mail'
        ],[
            'name' => 'mail' ,
            'response' => $json
        ]);

        return back()->with('success' , 'Smtp details updated successfully');
    }

}
