<?php

namespace App\Http\Controllers\Admin\Settings;

use App\Model\Option;
use App\Http\Requests\BrandValidation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Traits\DatatableTrait;

class OptionController extends Controller
{
    use DatatableTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->data['title'] =  'Attribute';
        return $this->view('admin.settings.option.index');
    }



    public function dataListing(Request $request)
    {

        // Listing colomns to show
        $columns = array(
            0 => 'id',
            1 => 'name',
            2 => 'id',
            3 => 'action',
        );


        $totalData = Option::count(); // datata table all count

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');
        $search = $request->input('search.value');

        // dd($request);

        // DB::enableQueryLog();
        // genrate a query
        $customcollections = Option::query();

        $totalData = $customcollections->count(); //

        $customcollections = $customcollections->when($search, function ($query, $search) {
            return $query->where('name', 'LIKE', "%{$search}%");
        });

        // dd($totalData);

        $totalFiltered = $customcollections->count();

        $customcollections = $customcollections->offset($start)->limit($limit)->orderBy($order, $dir)->get();

        $data = [];
        // dd($customcollections);
        foreach ($customcollections as $key => $item) {

            // dd(route('admin.brand.edit', $item->id));
            $row['id'] = $item->id;
            // $row['image'] = $this->image('brand', $item->brand_img , '25%');
            $row['name'] = $item->name;
            // $row['status'] = $this->status( $item->is_active , $item->id , route('admin.homepagebanners.status'))  ;
            $row['action'] = $this->action([
                collect([
                    'text' => 'Edit',
                    'id' => $item->id,
                    'action' => route('admin.option.edit', $item->id),
                    'target' => '#addcategory',
                    'class' => 'call-modal',
                    'icon' => 'fa fa-pen',
                    'permission' => true
                ]),
                collect([
                    'text' => 'Delete',
                    'id' => $item->id,
                    'icon' => 'fa fa-trash',
                    'action' => route('admin.option.destroy', $item->id),
                    'class' => 'delete-confirmation',
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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $html = view('admin.settings.option.create')->render();
        return response()->json(['html' => $html], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $brand = new Option();
        $brand->name = $request->name;
        $brand->save();

        return redirect()->route('admin.option.index')->with('success', __('settings.add_option'));
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
        //
        $option = Option::findOrFail($id);
        $html = view('admin.settings.option.edit', ['option' => $option])->render();
        return response()->json(['html' => $html], 200);
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
        //

        $brand = Option::findOrFail($id);
        $brand->name = $request->name;
        $brand->save();

        return redirect()->route('admin.option.index')->with('success', __('settings.update_option'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $statuscode = 400;

        $brand = Option::findOrFail($id);
        if ($brand->delete()) {
            $statuscode = 200;
        }

        return response()->json([
            'success' => true,
            'message' => __('settings.delete_option'),
        ], $statuscode);
    }

    public function hashExists(Request $request)
    {

        $slug = $request->get('name');

        $id = $request->get('id');

        $is_exist = Option::where('name', '=', $slug)->when($id, function ($query, $id) {
            return $query->where('id', '!=', $id);
        })->get();

        if ($is_exist->count() > 0) {
            return 'false';
        }

        return 'true';
    }
}
