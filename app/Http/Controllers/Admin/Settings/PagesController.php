<?php

namespace App\Http\Controllers\Admin\Settings;

use App\Model\Page;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Traits\DatatableTrait;

class PagesController extends Controller
{
    use DatatableTrait ;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->data['title'] = 'Pages' ;
        return view('admin.settings.pages.index',$this->data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->data['title'] = 'Pages' ;
        return view('admin.settings.pages.create',$this->data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $pages = new Page();

        $pages->title         = $request->title;
        $pages->bodyhtml      = $request->content;
        $pages->slug          = $request->url_handle;
        $pages->page_title    = $request->page_title ?? $request->title;
        $pages->meta_desc     = $request->meta_description;
        $pages->meta_keywords = $request->meta_keyword;
        $pages->handle        = $request->url_handle;

        if($request->file('slider_image')) {
            $file = $request->file('slider_image');
            $fileName = time() . '_' . rand(0, 500) . '_' . $file->getClientOriginalName();
            $fileName = str_replace(' ', '_', $fileName);
            $filepath = $file->storeAs('banner', $fileName);
            $pages->slider_image = $filepath;
        }


        $pages->save();

        return redirect()->route('admin.pages.index')->with('success' , __('settings.add_page'));

    }

    public function dataListing(Request $request)
    {

        // Listing colomns to show
        $columns = array(
            0 => 'id',
            1 => 'title',
            2 => 'action',
        );


        $totalData = Page::count(); // datata table count

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');
        $search = $request->input('search.value');

        // dd($request);

        // DB::enableQueryLog();
        // genrate a query
        $customcollections = Page::when($search, function ($query, $search) {
            return $query->where('title', 'LIKE', "%{$search}%");
        });

        // dd($totalData);

        $totalFiltered = $customcollections->count();

        $customcollections = $customcollections->offset($start)->limit($limit)->orderBy($order, $dir)->get();

        $data = [];
        // dd($customcollections);
        foreach ($customcollections as $key => $item) {


            $row['id'] = $item->id;
            $row['title'] = $item->title;
            $row['action'] = $this->action([
                collect([
                    'text' => 'Edit',
                    'action' => route('admin.pages.edit', $item->id),
                    'permission' => true,
                    'icon' => 'fas fa-edit'
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

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this->data['title'] = 'Page edit' ;
        $this->data['page'] = Page::findOrFail($id);
        return view('admin.settings.pages.edit',$this->data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {


        $pages = Page::findOrFail($id);

        $pages->title         = $request->title;
        $pages->bodyhtml      = $request->content;
        $pages->slug          = $request->url_handle;
        $pages->page_title    = $request->page_title ?? $request->title;
        $pages->meta_desc     = $request->meta_description;
        $pages->meta_keywords = $request->meta_keyword;
        $pages->handle        = $request->url_handle;

        if ($request->hasFile('slider_image')) {
            $file = $request->file('slider_image');
            $fileName = time() . '_' . rand(0, 500) . '_' . $file->getClientOriginalName();
            $fileName = str_replace(' ', '_', $fileName);
            $filepath = $file->storeAs('banner', $fileName);
            \Storage::delete('banner/' . $pages->slider_image);
            // $slider->slider_img = $fileName;
            $pages->slider_image = $filepath;
        }

        $pages->update();

        return redirect()->route('admin.pages.index')->with('success', __('settings.update_page'));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $statuscode = 400 ;

        $page = Page::findOrFail($id);

        if($page->delete()) {
            $statuscode = 200 ;
        }

        return response()->json([
            'success' => true ,
            'message' => __('settings.delete_page'),
        ],$statuscode);
    }

    public function slugExists(Request $request)
    {
        // dd($request);
        $slug = $request->get('url_handle');
        $id = $request->get('id');
        $is_exist = Page::where('slug', '=', $slug)->when($id, function ($query, $id) {
            return $query->where('id', '!=', $id);
        })->get();

        if ($is_exist->count() > 0) {
            return 'false';
        }
        return 'true';
    }



}
