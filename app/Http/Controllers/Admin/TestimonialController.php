<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\Testimonial;
use Illuminate\Http\Request;
use App\Traits\DatatableTrait;


class TestimonialController extends Controller
{
  use DatatableTrait;
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $this->data['title'] = 'Testimonials';
    return view('admin.testimonial.index', $this->data);
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    $this->data['title'] = 'Crete';
    return view('admin.testimonial.create', $this->data);
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    $testimonial = new Testimonial();
    $testimonial->rating = $request->rating ?? 1;
    $testimonial->name = $request->testimonial_name;
    $testimonial->description = $request->description;
    $testimonial->save();

    return redirect()->route('admin.testimonial.index')->with('success', 'Testimonial Created Successfully');
  }

  public function dataList(Request $request)
  {

    // Listing colomns to show
    $columns = array(
      'name',
      'rating',
      'action',
    );


    $totalData = Testimonial::count(); // datata table count

    $limit = $request->input('length');
    $start = $request->input('start');
    $order = $columns[$request->input('order.0.column')];
    $dir = $request->input('order.0.dir');
    $search = $request->input('search.value');

    // dd($request);

    // DB::enableQueryLog();
    // genrate a query
    $customcollections = Testimonial::when($search, function ($query, $search) {
      return $query->Where('name', 'LIKE', "%{$search}%")->orWhere('rating', 'LIKE', "%{$search}%");
    });

    // dd($totalData);

    $totalFiltered = $customcollections->count();

    $customcollections = $customcollections->offset($start)->limit($limit)->orderBy($order, $dir)->get();

    $data = [];
    // dd($customcollections);
    foreach ($customcollections as $key => $item) {

      // dd(route('admin.brand.edit', $item->id));
      $row['name']   =  $item->name == null ? $item->user->name : $item->name;
      $row['rating']  = $this->text($item->rating . ' <i class="fa fa-star"></i>');
      $row['status'] = $this->status($item->is_active, $item->id, route('admin.testimonial.status', $item->id));
      $row['action'] = $this->action([
        collect([
          'text' => 'Edit',
          'id' => $item->id,
          'action' => route('admin.testimonial.edit', $item->id),
          'icon' => 'fa fa-pen',
          'permission' => true
        ]),
        collect([
          'text' => 'Delete',
          'action' => route('admin.testimonial.destroy', $item->id),
          'id' => $item->id,
          'class' => 'delete-confirmation',
          'icon' => 'fa fa-trash',
          'permission' => true
        ]),

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
   * @param  \App\Model\Testimonial  $testimonial
   * @return \Illuminate\Http\Response
   */
  public function show(Testimonial $testimonial)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Model\Testimonial  $testimonial
   * @return \Illuminate\Http\Response
   */
  public function edit(Testimonial $testimonial)
  {
    
    $this->data['title'] = 'Edit';
    $this->data['testimonial'] = $testimonial;
    return $this->view('admin.testimonial.edit');
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Model\Testimonial  $testimonial
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, Testimonial $testimonial)
  {
    $testimonial->rating = $request->rating ?? 1;
    $testimonial->name = $request->testimonial_name;
    $testimonial->description = $request->description;
    $testimonial->save();

    return redirect()->route('admin.testimonial.index')->with('success', 'Testimonial Updated Successfully');
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Model\Testimonial  $testimonial
   * @return \Illuminate\Http\Response
   */
  public function destroy(Testimonial $testimonial)
  {
    $testimonial->delete();
    return response()->json([
      'success' => true,
      'message' => 'Testimonial deleted successfully'
    ], 200);
  }

  public function changeStatus(Request $request)
  {

    $statuscode = 400;
    $testimonial = Testimonial::findOrFail($request->id);
    $testimonial->is_active  =  $request->status == 'true' ? null :  date('Y-m-d H:i:s');

    if ($testimonial->save()) {
      $statuscode = 200;
    }
    $status = $request->status == 'true' ? 'active' : 'deactivate';
    $message = 'Testimonial ' . $status . ' successfully.';

    return response()->json([
      'success' => true,
      'message' => $message
    ], $statuscode);
  }
}