<?php

namespace App\Http\Controllers\Admin\Access;

use App\Http\Controllers\Controller;
use App\Traits\DatatableTrait;
use Str;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    use DatatableTrait;

    public function index()
    {
        $this->data['title'] = 'Permission';
        return $this->view('admin.access.permission.index');
    }


    public function create()
    {
        $html = view('admin.access.permission.create')->render();
        return response()->json([
            'success' => true,
            'html' => $html
        ], 200);
    }

    public function dataList(Request $request) {
        // Listing colomns to show
        $columns = array(
            0 => 'id',
            1 => 'name',
            3 => 'action',
        );


        $totalData = Permission::count(); // datata table count

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');
        $search = $request->input('search.value');

        // dd($request);

        // DB::enableQueryLog();
        // genrate a query
        $customcollections = Permission::when($search, function ($query, $search) {
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
            $row['name'] = '<b>'.$item->name.'</b>';

            $row['status'] = $this->status( $item->is_active , $item->id , route('admin.permission.status' ,['id' => $item->id]))  ;

            // $row['permission'] = $this->permition($item->id);

            $row['action'] = $this->action([
                collect([
                    'text' => 'Edit' ,
                    'id' => $item->id,
                    'action' => route('admin.permission.edit', $item->id),
                    'target' => '#addcategory' ,
                    'class' => 'call-modal' ,
                    'icon' => 'fa fa-pen',
                    'permission' => true
                ]),
                collect([
                    'text' => 'Delete' ,
                    'id' => $item->id,
                    'action' => route('admin.permission.destroy', ['permission' => $item->id]),
                    'class' => 'delete-confirmation' ,
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



    public function store(Request $request) {
        $permission = new Permission();
        $permission->name = $request->permissions_name;
        $permission->parent_id = $request->parent_id;
        $permission->slug = Str::slug($request->permissions_name);
        $permission->save();
        return redirect()->back()->with('success', 'Permission created successfully');
    }


    public function show(Request $request, Permission $permission)
    {
        //


    }

    public function edit(Request $request, Permission $permission)
    {
        //
        $html = view('admin.access.permission.edit',['permission' => $permission])->render();
        return response()->json([
            'success' => true,
            'html' => $html
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Permission $permission)
    {
        //
        $permission->name = $request->permissions_name;
        $permission->slug = Str::slug($request->permissions_name);
        $permission->save();
        return redirect()->back()->with('success', 'Permission updated successfully');
    }


    public function destroy($id)
    {
        //
        $permission = Permission::findOrfail($id);

        $permission->permissions()->detach();

        $permission->users()->detach();

        $permission->delete();

        return response()->json([
            'success' => true,
            'message' => 'permission deleted Success fully',
        ], 200 );
    }

    public function changeStatus(Request $request,$id)
    {
        $slider = Permission::findOrFail($request->id);
        $slider->is_active  = $request->status == 'true' ? null : date('Y-m-d H:i:s')  ;
        if($slider->save()) {
            $statuscode = 200 ;
        }

        $status = $request->status == 'true' ? 'active' : 'deactivate' ;
        $message = 'Permission '.$status.' successfully.' ;

        return response()->json([
            'success' => true ,
            'message' => $message
        ],$statuscode);

    }

    public function permissionExists(Request $request)
    {
        $id = $request->get('id');
        $countRec = $countRec = Permission::when($id != null, function ($query) use ($request) {
            return $query->where('id', '!=', $request->id);
        })
        ->where('slug', Str::slug($request->permissions_name))
        ->count();

        if ($countRec > 0) {
            return 'false';
        } else {
            return 'true';
        }
    }

    public function getPermissionList(Request $request)
    {
        $search = $request->get('search');
        $id = $request->get('id');
        $data = Permission::where('name', 'like', '%' . $search . '%')
                ->when($request->parent , function($query) use ($request) {
                        $query->whereNull('parent_id')  ;
                })
                ->when(!$search, function($q){
                    return $q->limit(15);
                })->whereNotNull('is_active')->get();

        return response()->json($data->toArray());
    }

}
