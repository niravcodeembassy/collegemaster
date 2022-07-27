<?php

namespace App\Http\Controllers\Admin\Settings;

use App\Http\Controllers\Controller;
use App\Model\OptionValue;
use App\Traits\DatatableTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class OptionValueController extends Controller
{
    use DatatableTrait;

    public function index()
    {
        $this->data['title'] = 'Attribute Value';
        return $this->view('admin.settings.optionvalue.index');
    }


    public function create()
    {
        $html = view('admin.settings.optionvalue.create')->render();
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


        $totalData = OptionValue::count(); // datata table count

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');
        $search = $request->input('search.value');

        // dd($request);

        // DB::enableQueryLog();
        // genrate a query
        $customcollections = OptionValue::when($search, function ($query, $search) {
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
            $row['name'] = '<b>' . ucfirst($item->name) . '</b>';
            $row['option'] = ucfirst($item->option->name)  ;
            $row['status'] = $this->status($item->is_active, $item->id, route('admin.optionvalue.status', ['id' => $item->id]));

            // $row['Optionvalue'] = $this->permition($item->id);

            $row['action'] = $this->action([
                collect([
                    'text' => 'Edit',
                    'id' => $item->id,
                    'action' => route('admin.optionvalue.edit', $item->id),
                    'target' => '#addcategory',
                    'class' => 'call-modal',
                    'icon' => 'fa fa-pen',
                    'permission' => true
                ]),
                collect([
                    'text' => 'Delete',
                    'id' => $item->id,
                    'action' => route('admin.optionvalue.destroy', $item->id),
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
        $optionvalue = new OptionValue();
        $optionvalue->name = $request->option_value;
        $optionvalue->option_id = $request->option_id;
        $optionvalue->save();
        return redirect()->back()->with('success', 'Attribute value created successfully');
    }


    public function show(Request $request, OptionValue $optionvalue)
    {
        //

    }

    public function edit(Request $request, OptionValue $optionvalue)
    {
        //
        $html = view('admin.settings.optionvalue.edit', ['optionvalue' => $optionvalue->load('option')])->render();
        return response()->json([
            'success' => true,
            'html' => $html
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Optionvalue  $optionvalue
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Optionvalue $optionvalue)
    {
        //
        $optionvalue->name = $request->option_value;
        $optionvalue->option_id = $request->option_id;
        $optionvalue->save();
        return redirect()->back()->with('success', 'Attribute value updated successfully');
    }


    public function destroy($id)
    {
        //
        $optionvalue = OptionValue::findOrfail($id);

        $optionvalue->delete();

        return response()->json([
            'success' => true,
            'message' => 'Attribute value deleted Success fully',
        ], 200);
    }

    public function changeStatus(Request $request, $id)
    {
        $slider = OptionValue::findOrFail($request->id);
        $slider->is_active  = $request->status == 'true' ? null : date('Y-m-d H:i:s');
        if ($slider->save()) {
            $statuscode = 200;
        }

        $status = $request->status == 'true' ? 'active' : 'deactivate';
        $message = 'Attribute value ' . $status . ' successfully.';

        return response()->json([
            'success' => true,
            'message' => $message
        ], $statuscode);
    }

    public function exists(Request $request)
    {
        $id = $request->get('id');
        $countRec = $countRec = OptionValue::when($id != null, function ($query) use ($request) {
            return $query->where('id', '!=', $request->id);
        })->where('option_id', $request->option)->where('name', $request->option_value)->count();

        if ($countRec > 0) {
            return 'false';
        } else {
            return 'true';
        }
    }


}
