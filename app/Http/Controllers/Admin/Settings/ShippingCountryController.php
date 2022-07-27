<?php

namespace App\Http\Controllers\Admin\Settings;

use App\Http\Controllers\Controller;
use App\Model\ShippingCountry;
use App\Traits\DatatableTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ShippingCountryController extends Controller
{
    use DatatableTrait;

    public function index()
    {
        $this->data['title'] = 'Shipping Country';
        return $this->view('admin.settings.shippingcountry.index');
    }


    public function create()
    {
        $html = view('admin.settings.shippingcountry.create')->render();
        return response()->json([
            'success' => true,
            'html' => $html
        ], 200);
    }

    public function dataList(Request $request)
    {
        // Listing colomns to show
        $columns = array(
            0 => 'id',
            1 => 'name',
            3 => 'action',
        );


        $totalData = ShippingCountry::count(); // datata table count

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');
        $search = $request->input('search.value');


        // DB::enableQueryLog();
        // genrate a query
        $customCollection = ShippingCountry::with('country')->when($search, function ($query, $search) {
            return $query->whereLike(['country.name','name'],  "%{$search}%");
        });

        // dd($totalData);

        $totalFiltered = $customCollection->count();

        $customCollection = $customCollection->offset($start)->limit($limit)->orderBy($order, $dir)->get();


        $data = [];
        // dd($customCollection);
        foreach ($customCollection as $key => $item) {
            // dd(route('admin.brand.edit', $item->id));
            $row['id'] = $item->id;
            $row['name'] = '<b>' . ucfirst($item->name) . '</b>';
            $row['option'] = ucfirst($item->country->name ?? '');
            $row['status'] = $this->status($item->is_active, $item->id, route('admin.shipping-country.status', ['id' => $item->id]));

            // $row['ShippingCountry'] = $this->permition($item->id);

            $row['action'] = $this->action([
                collect([
                    'text' => 'Edit',
                    'id' => $item->id,
                    'action' => route('admin.shipping-country.edit', $item->id),
                    'target' => '#addcategory',
                    'class' => 'call-modal',
                    'icon' => 'fa fa-pen',
                    'permission' => true
                ]),
                collect([
                    'text' => 'Delete',
                    'id' => $item->id,
                    'action' => route('admin.shipping-country.destroy', $item->id),
                    'class' => 'delete-confirmation',
                    'icon' => 'fa fa-trash',
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



    public function store(Request $request)
    {
        $shippingCountry = new ShippingCountry();
        $shippingCountry->name = $request->charge;
        $shippingCountry->country_id = $request->country_id;
        $shippingCountry->save();
        return redirect()->back()->with('success', 'Shipping country created successfully');
    }


    public function show(Request $request, ShippingCountry $shippingCountry)
    {
        //


    }

    public function edit(Request $request, ShippingCountry $shippingCountry)
    {
        //
        $html = view('admin.settings.shippingcountry.edit', ['optionvalue' => $shippingCountry->load('country')])->render();
        return response()->json([
            'success' => true,
            'html' => $html
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\ShippingCountry  $shippingCountry
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ShippingCountry $shippingCountry)
    {
        //
        $shippingCountry->name = $request->charge;
        $shippingCountry->country_id = $request->country_id;
        $shippingCountry->save();
        return redirect()->back()->with('success', 'Shipping Country updated successfully');
    }


    public function destroy($id)
    {
        //
        $shippingCountry = ShippingCountry::findOrfail($id);

        $shippingCountry->delete();

        return response()->json([
            'success' => true,
            'message' => 'Shipping Country deleted Success fully',
        ], 200);
    }

    public function changeStatus(Request $request, $id)
    {
        $slider = ShippingCountry::findOrFail($request->id);
        $slider->is_active  = $request->status == 'true' ? null : date('Y-m-d H:i:s');
        if ($slider->save()) {
            $statuscode = 200;
        }

        $status = $request->status == 'true' ? 'active' : 'deactivate';
        $message = 'Shipping Country ' . $status . ' successfully.';

        return response()->json([
            'success' => true,
            'message' => $message
        ], $statuscode);
    }

    public function exists(Request $request)
    {
        $id = $request->get('id');
        $countRec = $countRec = ShippingCountry::when($id != null, function ($query) use ($request) {
            return $query->where('id', '!=', $request->id);
        })->where('country_id', $request->option)->where('name', $request->charge)->count();

        if ($countRec > 0) {
            return 'false';
        } else {
            return 'true';
        }
    }
}
