<?php

namespace App\Http\Controllers\Admin;

use App\Model\Contact;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Traits\DatatableTrait;

class ContactController extends Controller
{
    use DatatableTrait ;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       $this->data['title'] =  'Contact' ;
       return view('admin.contact.index' , $this->data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
    }

    public function dataListing(Request $request)
    {

        // Listing colomns to show
        $columns = array(
            0 => 'name',
            1 => 'email',
            2 => 'phone',
            3 => 'subject',
            4 => 'action',
        );


        $totalData = Contact::count(); // datata table count

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');
        $search = $request->input('search.value');

        // dd($request);

        // DB::enableQueryLog();
        // genrate a query
        $customcollections = Contact::when($search, function ($query, $search) {
            return $query->where('name', 'LIKE', "%{$search}%");
        });

        // dd($totalData);

        $totalFiltered = $customcollections->count();

        $customcollections = $customcollections->offset($start)->limit($limit)->orderBy($order, $dir)->get();

        $data = [];
        // dd($customcollections);
        foreach ($customcollections as $key => $item) {
            
            // dd(route('admin.brand.edit', $item->id));
            $row['name'] = $item->name;
            $row['email'] = $item->email;
            $row['phone'] = $item->phone;
            $row['subject'] = $item->subject;
            // $row['status'] = $this->status( $item->is_active , $item->id , route('admin.homepagebanners.status'))  ;
            $row['action'] = $this->action([
                collect([
                    'text' => 'View',
                    'class' => 'call-modal',
                    'icon' => 'fa fa-eye',
                    'action' => route('admin.contact.show', $item->id),
                    'target' => '#contactview' ,
                    'permission' => true
                ])
                // 'delete' => collect([
                //     'id' => $item->id,
                //     'action' => route('admin.brand.destroy', $item->id),
                // ])                
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
        $contact = Contact::findOrFail($id);
        $html = view('admin.contact.view',[ 'contact' => $contact])->render() ;
        return response()->json([ 'html' => $html ], 200);      

        // $contact = Contact::findOrFail($id);
        // $html = view('admin.contact.view',[ 'contact' => $contact])->render() ;
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
    }
}
