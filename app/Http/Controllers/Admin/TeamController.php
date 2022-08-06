<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\Team;
use Aj\FileUploader\FileUploader;
use Illuminate\Http\Request;
use App\Traits\DatatableTrait;

class TeamController extends Controller
{
  use DatatableTrait;
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $this->data['title'] = 'Team Member';
    return $this->view('admin.member.index');
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    $this->data['title'] = 'Create';
    return $this->view('admin.member.create');
  }

  public function dataListing(Request $request)
  {
    // Listing colomns to show
    $columns = array(
      0 => 'title',
      1 => 'designation',
      3 => 'action',
    );


    $totalData = Team::count(); // datata table count

    $limit = $request->input('length');
    $start = $request->input('start');
    $order = $columns[$request->input('order.0.column')];
    $dir = $request->input('order.0.dir');
    $search = $request->input('search.value');

    // genrate a query
    $customcollections = Team::when($search, function ($query, $search) {
      return $query->where('title', 'LIKE', "%{$search}%")->orWhere('designation', 'LIKE', "%{$search}%");
    });

    $totalFiltered = $customcollections->count();

    $customcollections = $customcollections->offset($start)->limit($limit)->orderBy($order, $dir)->get();

    $data = [];

    // dd($customcollections);
    foreach ($customcollections as $key => $item) {
      // dd(route('admin.brand.edit', $item->id));
      $row['title'] = '<b>' . $item->title . '</b>';
      $row['designation'] = $item->designation;
      $row['status'] = $this->status($item->is_active, $item->id, route('admin.team.status', ['id' => $item->id]));
      $row['action'] = $this->action([
        collect([
          'text' => 'Edit',
          'id' => $item->id,
          'action' => route('admin.team.edit', $item->id),
          'icon' => 'fa fa-pen',
          'permission' => true
        ]),
        collect([
          'text' => 'Delete',
          'id' => $item->id,
          'action' => route('admin.team.destroy', ['team' => $item->id]),
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
    $team = new Team();
    $team->title = $request->title;
    $team->designation = $request->designation;
    $team->image = FileUploader::make($request->images)->upload('member');
    $team->save();

    return redirect()->route('admin.team.index')->with('success', 'Member Created Successfully');
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Model\Team  $team
   * @return \Illuminate\Http\Response
   */
  public function show(Team $team)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Model\Team  $team
   * @return \Illuminate\Http\Response
   */
  public function edit(Team $team)
  {
    $this->data['title'] = 'Edit';
    $this->data['team'] = $team;
    return $this->view('admin.member.edit');
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Model\Team  $team
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, Team $team)
  {
    $team->title = $request->title;
    $team->designation = $request->designation;
    $team->image = FileUploader::make($request->images)->upload('member', $team->image);
    $team->save();

    return redirect()->route('admin.team.index')->with('success', 'Member Updated Successfully');
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Model\Team  $team
   * @return \Illuminate\Http\Response
   */
  public function destroy(Team $team)
  {
    $team->delete();

    return response()->json([
      'success' => true,
      'message' => 'Member Deleted SuccessFully'
    ], 200);
  }

  public function changeStatus(Request $request, $id)
  {
    $team = Team::findOrFail($request->id);
    $team->is_active  = $request->status == 'true' ? null :  date('Y-m-d H:i:s');

    if ($team->save()) {
      $statuscode = 200;
    }

    $status = $request->status == 'true' ? 'active' : 'deactivate';
    $message = "Member $status successfully.";

    return response()->json([
      'success' => true,
      'message' => $message
    ], $statuscode ?? 400);
  }
}