<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\MessageSnippet;
use Illuminate\Http\Request;
use App\Traits\DatatableTrait;

class MessageSnippetController extends Controller
{
  use DatatableTrait;
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $this->data['title'] = 'Message Snippet';
    return $this->view('admin.message-snippet.index');
  }

  public function dataList(Request $request)
  {
    // Listing colomns to show
    $columns = array(
      0 => 'id',
      1 => 'title',
      3 => 'action',
    );

    $totalData = MessageSnippet::count(); // datata table count

    $limit = $request->input('length');
    $start = $request->input('start');
    $order = $columns[$request->input('order.0.column')];
    $dir = $request->input('order.0.dir');
    $search = $request->input('search.value');

    // dd($request);

    // DB::enableQueryLog();
    // genrate a query
    $customCollections = MessageSnippet::when($search, function ($query, $search) {
      return $query->where('description', 'LIKE', "%{$search}%")->orWhere('title', 'LIKE', "%{$search}%");
    });

    $totalFiltered = $customCollections->count();

    $customCollections = $customCollections->offset($start)->limit($limit)->orderBy($order, $dir)->get();

    $data = [];

    foreach ($customCollections as $key => $item) {
      $row['id'] = $item->id;
      $row['title'] = '<b>' . $item->title . '</b>';
      $row['status'] = $this->status($item->is_active, $item->id, route('admin.message-snippet.status', ['id' => $item->id]));
      $row['action'] = $this->action([
        collect([
          'text' => 'Edit',
          'id' => $item->id,
          'action' => route('admin.message-snippet.edit', $item->id),
          'icon' => 'fa fa-pen',
          'permission' => true,
        ]),
        collect([
          'text' => 'Delete',
          'id' => $item->id,
          'action' => route('admin.message-snippet.destroy', ['message_snippet' => $item->id]),
          'class' => 'delete-confirmation',
          'icon' => 'fa fa-trash',
          'permission' => true,
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
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    $this->data['title'] = 'Create';
    return $this->view('admin.message-snippet.create');
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    $messageSnippet = new MessageSnippet();
    $messageSnippet->title = $request->title;
    $messageSnippet->description = $request->description;
    $messageSnippet->save();

    return redirect()->route('admin.message-snippet.index')->with('success', 'Message Created Successfully');
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Model\MessageSnippet  $messageSnippet
   * @return \Illuminate\Http\Response
   */
  public function show(MessageSnippet $messageSnippet)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Model\MessageSnippet  $messageSnippet
   * @return \Illuminate\Http\Response
   */
  public function edit(MessageSnippet $messageSnippet)
  {

    $this->data['title'] = 'Create';
    $this->data['snippet'] = $messageSnippet;
    return $this->view('admin.message-snippet.edit');
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Model\MessageSnippet  $messageSnippet
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, MessageSnippet $messageSnippet)
  {
    $messageSnippet->title = $request->title;
    $messageSnippet->description = $request->description;
    $messageSnippet->save();

    return redirect()->route('admin.message-snippet.index')->with('success', 'Message Updated Successfully');
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Model\MessageSnippet  $messageSnippet
   * @return \Illuminate\Http\Response
   */
  public function destroy(MessageSnippet $messageSnippet)
  {
    $messageSnippet->delete();

    return response()->json([
      'success' => true,
      'message' => 'Message Deleted SuccessFully',
    ], 200);
  }

  public function changeStatus(Request $request, $id)
  {
    $messageSnippet = MessageSnippet::findOrFail($request->id);
    $messageSnippet->is_active = $request->status == 'true' ? null : date('Y-m-d H:i:s');

    if ($messageSnippet->save()) {
      $statusCode = 200;
    }

    $status = $request->status == 'true' ? 'active' : 'deactivate';
    $message = "Message $status successfully.";

    return response()->json([
      'success' => true,
      'message' => $message,
    ], $statusCode ?? 400);
  }
}