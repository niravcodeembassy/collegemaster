<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Tag;
use App\Traits\DatatableTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Tagcontroller extends Controller
{
  use DatatableTrait;
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $this->data['title'] = 'Tag';
    return $this->view('admin.tag.index');
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    $html = view('admin.tag.create')->render();
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


    $totalData = Tag::count(); // datata table count

    $limit = $request->input('length');
    $start = $request->input('start');
    $order = $columns[$request->input('order.0.column')];
    $dir = $request->input('order.0.dir');
    $search = $request->input('search.value');

    // dd($request);

    // DB::enableQueryLog();
    // genrate a query
    $customCollections = Tag::when($search, function ($query, $search) {
      return $query->where('name', 'LIKE', "%{$search}%");
    });

    // dd($totalData);

    $totalFiltered = $customCollections->count();

    $customCollections = $customCollections->offset($start)->limit($limit)->orderBy($order, $dir)->get();

    $data = [];
    // dd($customCollections);
    foreach ($customCollections as $key => $item) {

      // dd(route('admin.brand.edit', $item->id));
      $row['id'] = $item->id;
      $row['name'] = '<b>' . $item->name . '</b>';

      $row['status'] = $this->status($item->is_active, $item->id, route('admin.tag.status', ['id' => $item->id]));

      $row['permission'] = $this->permition($item->id);

      $row['action'] = $this->action([
        collect([
          'text' => 'Edit',
          'id' => $item->id,
          'action' => route('admin.tag.edit', $item->id),
          'target' => '#editag',
          'class' => 'call-modal',
          'icon' => 'fa fa-pen',
          'permission' => true
        ]),
        collect([
          'text' => 'Delete',
          'id' => $item->id,
          'action' => route('admin.tag.destroy', ['tag' => $item->id]),
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

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    $tag = new Tag();
    $tag->name = $request->tag_name;
    $tag->save();
    return redirect()->back()->with('success', 'Tag created successfully');
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Tag  $tag
   * @return \Illuminate\Http\Response
   */
  public function show(Tag $tag)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Tag  $tag
   * @return \Illuminate\Http\Response
   */
  public function edit(Tag $tag)
  {
    $html = view('admin.tag.edit', ['tag' => $tag])->render();
    return response()->json([
      'success' => true,
      'html' => $html
    ], 200);
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Tag  $tag
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, Tag $tag)
  {
    $tag->name = $request->tag_name;
    $tag->save();
    return redirect()->back()->with('success', 'Tag Updated Successfully');
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Tag  $tag
   * @return \Illuminate\Http\Response
   */
  public function destroy(Tag $tag)
  {
    if (DB::table('blog_tag')->where('tag_id', $tag->id)->doesntExist()) {
      $tag->delete();
      return response()->json([
        'success' => true,
        'message' => 'Role deleted Success fully',
      ], 200);
    }
    return response()->json([
      'error' => true,
      'message' => 'Tag Use In blog can not be deleted',
    ], 400);
  }

  public function changeStatus(Request $request, $id)
  {
    $tag = Tag::findOrFail($request->id);
    $tag->is_active  = $request->status == 'true' ? null :  date('Y-m-d H:i:s');

    if ($tag->save()) {
      $statuscode = 200;
    }

    $status = $request->status == 'true' ? 'active' : 'deactivate';
    $message = 'Tag ' . $status . ' successfully.';

    return response()->json([
      'success' => true,
      'message' => $message
    ], $statuscode);
  }

  public function exists(Request $request)
  {
    $id = $request->get('id');
    $countRec = $countRec = Tag::when($id != null, function ($query) use ($request) {
      return $query->where('id', '!=', $request->id);
    })
      ->where('name', $request->tag_name)
      ->count();

    if ($countRec > 0) {
      return 'false';
    } else {
      return 'true';
    }
  }
  
  public function getTagList(Request $request)
  {
    $search = $request->get('search');
    $id = $request->get('id');
    $data = Tag::where('name', 'like', '%' . $search . '%')->whereNull('is_active')->get();
    return response()->json($data->toArray());
  }
}