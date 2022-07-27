<?php

namespace App\Http\Controllers\Admin\Access;

use App\Http\Controllers\Controller;
use App\Permission;
use App\Traits\DatatableTrait;
use \Spatie\Permission\Models\Role;
use Str;
use DB;
use Exception;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    use DatatableTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->data['title'] = 'Role';
        return $this->view('admin.access.role.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $html = view('admin.access.role.create')->render();
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


        $totalData = Role::count(); // datata table count

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');
        $search = $request->input('search.value');

        // dd($request);

        // DB::enableQueryLog();
        // genrate a query
        $customcollections = Role::when($search, function ($query, $search) {
            return $query->where('description', 'LIKE', "%{$search}%");
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

            $row['status'] = $this->status( $item->is_active , $item->id , route('admin.role.status' ,['id' => $item->id]))  ;

            $row['permission'] = $this->permition($item->id);

            $row['action'] = $this->action([
                collect([
                    'text' => 'Edit' ,
                    'id' => $item->id,
                    'action' => route('admin.role.edit', $item->id),
                    'target' => '#addcategory' ,
                    'class' => 'call-modal' ,
                    'icon' => 'fa fa-pen',
                    'permission' => true
                ]),
                collect([
                    'text' => 'Delete' ,
                    'id' => $item->id,
                    'action' => route('admin.role.destroy', ['role' => $item->id]),
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request) {
        $role = new Role();
        $role->name = $request->roles_name;
        $role->slug = Str::slug($request->roles_name);
        $role->save();
        return redirect()->back()->with('success', 'Role created successfully');
    }


       /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request , Role $role)
    {
        $role = $role->load('permissions');

        $this->role_permission = $role->permissions->pluck('id');
        $this->data['role'] = $role;

        $viewIcon = "fas fa-eye text-warning" ;
        $addIcon = "fas fa-plus text-primary" ;
        $editIcon = "fas fa-pen text-info " ;
        $deleteIcon = "fas fa-trash text-danger" ;

        $permition = Permission::with('childs')->whereNull('parent_id')->get();
        $slef = $this ;
        $permission = $permition->map(function($value ,$index) use ($slef) {
            $children = $slef->hasChiled($value->childs) ;
            if(empty($children)) {
                $selected = $this->role_permission->contains($value->id) ;
            }
            return  [
                "text" =>  $value->name ,
                "id" =>  $value->id ,
                "icon"=>  $value->icon ,
                "state" => [
                    "opened"=> false  ,
                    "selected" =>  $selected??false ,
                ] ,
                "children" => $children ?? []
            ] ;
        });

        $this->data['permissions'] = $permission->count() > 0 ? $permission->toArray() : [] ;

        return view('admin.access.role.assign_permission',$this->data);

    }

    public function hasChiled($data){

        if($data == null) {
            return null ;
        }

        $chiled = [] ;

        foreach ($data as $key => $value) {
            $children = $this->hasChiled($value->childs) ;
            $selected = false ;
            if(empty($children)) {
                $selected = $this->role_permission->contains($value->id) ;
            }
            $chiled [] = [
                "text" =>  $value->name  ,
                "id" =>  $value->id ,
                "icon"=>  $value->icon ??'' ,
                "state" => [
                    "selected" =>  $selected ,
                    "opened"=> true
                ] ,
                "children" => $children ?? []
            ] ;
        }

        return $chiled ;

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Role $role)
    {
        //
        $html = view('admin.access.role.edit',['role' => $role])->render();
        return response()->json([
            'success' => true,
            'html' => $html
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Role $role)
    {
        //
        $role->name = $request->roles_name;
        $role->slug = Str::slug($request->roles_name);
        $role->save();
        return redirect()->back()->with('success', 'Role updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $role = Role::findOrfail($id);

        $role->permissions()->detach();

        $role->users()->detach();

        $role->delete();

        return response()->json([
            'success' => true,
            'message' => 'Role deleted Success fully',
        ], 200 );
    }

    public function changeStatus(Request $request,$id)
    {
        $slider = Role::findOrFail($request->id);
        $slider->is_active  = $request->status == 'true' ? null :  date('Y-m-d H:i:s') ;

        if($slider->save()) {
            $statuscode = 200 ;
        }

        $status = $request->status == 'true' ? 'active' : 'deactivate' ;
        $message = 'Role '.$status.' successfully.' ;

        return response()->json([
            'success' => true ,
            'message' => $message
        ],$statuscode);

    }

    public function roleExists(Request $request)
    {
        $id = $request->get('id');
        $countRec = $countRec = Role::when($id != null, function ($query) use ($request) {
            return $query->where('id', '!=', $request->id);
        })
        ->where('slug', Str::slug($request->roles_name))
        ->count();

        if ($countRec > 0) {
            return 'false';
        } else {
            return 'true';
        }
    }


    public function assignPermission(Request $request , Role $role)
    {
        try {

            $role->syncPermissions($request->permission);

            return response()->json(['success' => true, 'message' => 'Permission assign successfully'], 200);

        } catch (Exception $e) {

            return response()->json(['success' => false , 'message' => 'Something went wrong please try again'], 400);

        }
    }

    public function getRoleList(Request $request)
    {
        $search = $request->get('search');
        $id = $request->get('id');
        $data = Role::where('name', 'like', '%' . $search . '%')->whereNull('is_active')->get();
        return response()->json($data->toArray());
    }


}
