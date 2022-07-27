<?php

namespace App\Http\Controllers\Admin\Settings;

use App\Model\Homepagebanner;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Traits\DatatableTrait;

class HomepagebannerController extends Controller
{
    use DatatableTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->data['title'] = 'Home page slider';
        return view('admin.settings.home-page-banner.index', $this->data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->data['title'] = 'Homepagebanners';
        return view('admin.settings.home-page-banner.create', $this->data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $slider = new Homepagebanner();
        $slider->title = $request->title;
        $slider->title_position = $request->title_position;
        $slider->content = $request->input('content');
        $slider->content_position = $request->content_position;

        $slider->btn_name = $request->btn_name;
        $slider->btn_url = $request->btn_url;

        if ($request->file('slider_image')) {
            $file = $request->file('slider_image');
            $fileName = time() . '_' . rand(0, 500) . '_' . $file->getClientOriginalName();
            $fileName = str_replace(' ', '_', $fileName);
            $path = $file->storeAs('banner', $fileName);
        }

        if ($request->file('mobile_slider_image')) {
            $file = $request->file('mobile_slider_image');
            $fileName = time() . '_' . rand(0, 500) . '_' . $file->getClientOriginalName();
            $fileName = str_replace(' ', '_', $fileName);
            $mobile_path = $file->storeAs('banner', $fileName);
        }

        $slider->slider_img = $path ?? null;
        $slider->mobile_slider_image = $mobile_path ?? null;
        $slider->btn_name = $request->btn_name;
        $slider->btn_url = $request->btn_url;
        $slider->btn_position = $request->btn_position;

        $slider->save();

        return redirect()->route('admin.homepagebanners.index')->with('success', __('settings.add_banner'));
    }

    public function dataListing(Request $request)
    {

        // Listing colomns to show
        $columns = array(
            0 => 'id',
            1 => 'image',
            1 => 'mobileimage',
            2 => 'title',
            3 => 'status',
            4 => 'action',
        );


        $totalData = Homepagebanner::count(); // datata table count

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');
        $search = $request->input('search.value');

        // dd($request);

        // DB::enableQueryLog();
        // genrate a query
        $customcollections = Homepagebanner::when($search, function ($query, $search) {
            return $query->where('title', 'LIKE', "%{$search}%");
        });

        // dd($totalData);

        $totalFiltered = $customcollections->count();

        $customcollections = $customcollections->offset($start)->limit($limit)->orderBy($order, $dir)->get();

        $data = [];
        // dd($customcollections);
        foreach ($customcollections as $key => $item) {

            $row['id'] = $item->id;
            $row['image'] = $this->image('', $item->slider_img, '25%');
            $row['mobileimage'] = $this->image('', $item->mobile_slider_image, '25%');
            $row['title'] = $item->title;
            $row['status'] = $this->status($item->is_active, $item->id, route('admin.homepagebanners.status'));
            $row['action'] = $this->action([
                collect([
                    'text' => 'Edit',
                    'icon' => 'fa fa-pen',
                    'id' => $item->id,
                    'action' => route('admin.homepagebanners.edit', $item->id),
                    'permission' => true
                ]),
                collect([
                    'text' => 'Delete',
                    'icon' => 'fa fa-trash',
                    'id' => $item->id,
                    'action' => route('admin.homepagebanners.destroy', $item->id),
                    'class' => 'delete-confirm',
                    'permission' => true
                ])
            ]);

            $data[] = $row;
        }

        $json_data = array(
            "draw" => intval($request->input('draw')),
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data,
        );

        return response()->json($json_data);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $this->data['title'] = 'Home page banner edit';
        $this->data['slider'] = Homepagebanner::findOrFail($id);
        return view('admin.settings.home-page-banner.edit', $this->data);
    }

    public function update(Request $request, $id)
    {

        $slider = Homepagebanner::findOrFail($id);
        $slider->title = $request->title;
        $slider->title_position = $request->title_position;
        $slider->content = $request->input('content');
        $slider->content_position = $request->content_position;



        if ($request->hasFile('slider_image')) {
            $file = $request->file('slider_image');
            $fileName = time() . '_' . rand(0, 500) . '_' . $file->getClientOriginalName();
            $fileName = str_replace(' ', '_', $fileName);
            $path = $file->storeAs('banner', $fileName);

            \Storage::delete('banner/' . $slider->slider_img);
            $slider->slider_img = $path;
        }

        if ($request->hasFile('mobile_slider_image')) {
            $file = $request->file('mobile_slider_image');
            $fileName = time() . '_' . rand(0, 500) . '_' . $file->getClientOriginalName();
            $fileName = str_replace(' ', '_', $fileName);
            $mobile_slider_image = $file->storeAs('banner', $fileName);

            \Storage::delete('banner/' . $slider->mobile_slider_image);
            $slider->mobile_slider_image = $mobile_slider_image;
        }

        $slider->btn_name = $request->btn_name;
        $slider->btn_url = $request->btn_url;
        $slider->btn_position = $request->btn_position;
        $slider->is_active = $request->status;
        $slider->update();

        return redirect()->route('admin.homepagebanners.index')->with('success', __('settings.update_banner'));
    }

    public function destroy($id)
    {
        $statuscode = 400;

        $slider = Homepagebanner::findOrFail($id);

        \Storage::delete('banner/' . $slider->slider_img);

        if ($slider->delete()) {
            $statuscode = 200;
        }

        return response()->json([
            'success' => true,
            'message' => __('settings.delete_banner'),
        ], $statuscode);
    }

    public function changeStatus(Request $request)
    {

        $statuscode = 400;
        $slider = Homepagebanner::findOrFail($request->id);
        $slider->is_active  = $request->status == 'true' ? NULL : date('d-m-Y');

        if ($slider->save()) {
            $statuscode = 200;
        }
        $status = $request->status == 'true' ? 'active' : 'deactivate';
        $message = 'Banner ' . $status . ' successfully.';

        return response()->json([
            'success' => true,
            'message' => $message
        ], $statuscode);
    }
}
