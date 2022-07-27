<?php

namespace App\Http\Controllers\Admin\Access;

use App\Admin;
use App\Exceptions\GeneralException;
use App\Http\Controllers\Controller;
use App\Traits\DatatableTrait;
use Carbon\Carbon;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;

class UserController extends Controller
{

    use DatatableTrait;

    public function __construct(Request $requet)
    {
        $this->requet = $requet;
    }

    public function index()
    {

        $this->data['title'] = "Users";

        return $this->view('admin.access.user.index');
    }

    public function create()
    {

        $this->data['title'] = "Create User";
        return $this->view('admin.access.user.create');
    }

    public function store(Request $request)
    {
        $data = $request->all();

        $user = new Admin();
        
        //define user role and permission
        $this->syncUser($user ,$data);

        return back()->with('success', 'User created succesfully');
        
    }

    public function dataList(Request $request)
    {

        // Listing colomns to show
        $columns = array(
            0 => 'name',
            1 => 'email',
            2 => 'roles',
            3 => 'is_active',
            4 => 'action',
        );

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');
        $search = $request->input('search.value');

        // dd($request);

        // DB::enableQueryLog();
        // genrate a query
        $customcollections = Admin::with('roles:id,name');

        $recordsTotal = $recordsFiltered = $customcollections->count(); // without serarch

        $customcollections = $customcollections->when($search, function ($query, $search) {
            return $query->where('email', 'LIKE', "%{$search}%");
        })->when($search,function ($query, $search) use (&$recordsFiltered) {
            $recordsFiltered = $query->count();
            return $query;
        });
        
        // $recordsFiltered = $customcollections->count(); // without serarch

        $customcollections = $customcollections->offset($start)->limit($limit)->orderBy($order, $dir)->get();

        $data = [];
        // dd($customcollections);
        foreach ($customcollections as $key => $item) {

            // dd(route('admin.brand.edit', $item->id));
            $row['id'] = $item->id;
            $row['name'] = $item->name;
            $row['email'] = $item->email;
            $row['status'] = $this->status($item->is_active, $item->id, route('admin.user.status', ['id' => $item->id]));
            $row['roels'] = $item->roles->map(function($item,$index){
                    return '<span class="badge badge-primary  badge-pill p-2">'.$item->name.'</span>';
            })->join(' ');
            $row['action'] = $this->action([
                collect([
                    'text' => 'Edit',
                    'id' => $item->id,
                    'action' => route('admin.user.edit', $item->id),
                    'icon' => 'fa fa-pen',
                    'permission' => true
                ]),
                collect([
                    'text' => 'Delete',
                    'id' => $item->id,
                    'action' => route('admin.user.destroy', ['user' => $item->id]),
                    'class' => 'delete-confirmation',
                    'icon' => 'fa fa-trash',
                    'permission' => true
                ])
            ]);

            $data[] = $row;
        }

        $json_data = array(
            "draw" => intval($request->input('draw')),
            "recordsTotal" => intval($recordsTotal),
            "recordsFiltered" => intval($recordsFiltered),
            "data" => $data,
        );

        return response()->json($json_data);
    }

    public function edit(Request $request, Admin $user)
    {
        $user->load('roles','permissions');
        $this->data['title'] = "User eidt";
        $this->data['user'] = $user;
        return $this->view('admin.access.user.edit');
    }

    public function changeStatus(Request $request, $id)
    {

        $userAdmin = Admin::findOrFail($request->id);
        $userAdmin->is_active  = $request->status == 'true' ? null  : date('Y-m-d H:i:s', time());
        if ($userAdmin->save()) {
            $statuscode = 200;
        }
        $status = $request->status == 'true' ? 'active' : 'deactivate';
        $message = 'User ' . $status . ' successfully.';

        return response()->json([
            'success' => true,
            'message' => $message
        ], $statuscode);
    }

    public function update(Request $request , Admin $user)
    {
        $data = $request->all();
        $data['confirmed'] = $user->email_verified_at;
        //define user role and permission
        $this->syncUser($user ,$data);

        return redirect()->route('admin.user.index')->with('success', 'User created successfully');

    }

    private function syncUser($user ,$data)
    {

        $user->first_name = $data['first_name'];
        $user->last_name = $data['last_name'];
        $user->email = $data['email'];
        $user->password = $data['password'];
        $user->is_active = isset($data['is_active']) ? Carbon::now()->format('Y-m-d H:i:s') : null;
        $user->email_verified_at = isset($data['confirmed']) ? Carbon::now()->format('Y-m-d H:i:s') : null;
        $user->name = null;
        $user->save();

        //define user role and permission
        if ($user) {
            if (!$user->email_verified_at) {
                event(new Registered($user));
            }
            $user->syncRoles(request()->input('role', []));
            $user->syncPermissions(request()->input('permission', []));
        }

        return $user;

    }
    
    public function destroy(Request $request ,Admin $user) {
        
        $user->delete();
        return response()->json([
            'message' => 'User delete successfully'
        ]);

    }

    public function emailUnique(Request $request) {
        
        $id = $request->id ;
        $email = $request->email ;
        $hasEmail = Admin::when($id,function($q , $id) {
            return $q->where('id' ,'!=' ,$id);
        })->where('email' , $email)->first();
        
        if(!$hasEmail) {
            return 'true';
        }

        return 'false';

    }

}
