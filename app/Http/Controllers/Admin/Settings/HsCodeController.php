<?php

namespace App\Http\Controllers\Admin\Settings;

use App\Model\HsCode;
use App\Http\Requests\BrandValidation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Traits\DatatableTrait;

class HsCodeController extends Controller
{
    use DatatableTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->data['title'] =  'HSN Code';
        return $this->view('admin.settings.hscode.index');
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


        $totalData = HsCode::count(); // datata table all count

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');
        $search = $request->input('search.value');

        // dd($request);

        // DB::enableQueryLog();
        // genrate a query
        $customcollections = HsCode::query();

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
                    'action' => route('admin.hscode.edit', $item->id),
                    'target' => '#addcategory',
                    'class' => 'call-modal',
                    'icon' => 'fa fa-pen',
                    'permission' => true
                ]),
                collect([
                    'text' => 'Delete',
                    'id' => $item->id,
                    'icon' => 'fa fa-trash',
                    'action' => route('admin.hscode.destroy', $item->id),
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
        $html = view('admin.settings.hscode.create')->render();
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
        $brand = new HsCode();
        $brand->name = $request->name;
        $brand->percentage = $request->percentage;
        $brand->save();

        return redirect()->route('admin.hscode.index')->with('success', 'HSN code created successfully');
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
        $hscode = HsCode::findOrFail($id);
        $html = view('admin.settings.hscode.edit', ['hscode' => $hscode])->render();
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

        $brand = HsCode::findOrFail($id);
        $brand->name = $request->name;
        $brand->percentage = $request->percentage;
        $brand->save();

        return redirect()->route('admin.hscode.index')->with('success', 'HSN code update successfully');
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

        $brand = HsCode::findOrFail($id);
        if ($brand->delete()) {
            $statuscode = 200;
        }

        return response()->json([
            'success' => true,
            'message' => 'HSN code deleted successfully',
        ], $statuscode);
    }

    public function hashExists(Request $request)
    {

        $slug = $request->get('name');

        $id = $request->get('id');

        $is_exist = HsCode::where('name', '=', $slug)->when($id, function ($query, $id) {
            return $query->where('id', '!=', $id);
        })->get();

        if ($is_exist->count() > 0) {
            return 'false';
        }

        return 'true';
    }
}
