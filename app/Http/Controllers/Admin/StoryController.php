<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\Story;
use App\Model\StoryImage;
use Illuminate\Http\Request;
use App\Traits\DatatableTrait;
use Illuminate\Support\Facades\DB;
use Aj\FileUploader\FileUploader;

class StoryController extends Controller
{
  use DatatableTrait;
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $this->data['title'] = 'Our Story';
    return $this->view('admin.story.index');
  }

  public function dataListing(Request $request)
  {
    // Listing columns to show
    $columns = array(
      0 => 'id',
      1 => 'title',
      2 => 'action',
    );


    $totalData = Story::count(); // datatatable count

    $limit = $request->input('length');
    $start = $request->input('start');
    $order = $columns[$request->input('order.0.column')];
    $dir = $request->input('order.0.dir');
    $search = $request->input('search.value');

    // dd($request);

    // DB::enableQueryLog();
    // generate a query
    $featureCollection = Story::when($search, function ($query, $search) {
      return $query->where('title', 'LIKE', "%{$search}%");
    });

    $totalData = $totalFiltered = $featureCollection->count(); // datatable count
    // dd($totalData);

    $featureCollection = $featureCollection->offset($start)->limit($limit)->orderBy($order, $dir)->get();

    $data = [];
    // dd($featureCollection);
    foreach ($featureCollection as $key => $item) {
      $row['id'] = $item->id;
      $row['title'] = '<b>' . $item->title . '</b>';
      $row['action'] = $this->action([
        collect([
          'text' => 'Edit',
          'id' => $item->id,
          'action' => route('admin.story.edit', ['story' => $item->id]),
          'icon' => 'fa fa-pen',
          'permission' => false
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
    return $this->view('admin.story.create');
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {

    $story = new Story();
    $story->title = $request->title;
    $story->video_url = $request->video_url;
    $story->instagram_handle = $request->instagram_handle;
    $story->instagram_handle_url = $request->instagram_handle_url;
    $story->description = $request->description;
    $story->save();

    foreach ($request->caption as $key => $value) {
      $story_image = new StoryImage();
      $file = FileUploader::make($request->file('post_image_' . $key, null))->upload('story_image', $story_image->image ?? null);
      $story_image->url = $request->input('url.' . $key);
      $story_image->image = $file;
      $story_image->caption = $request->input('caption.' . $key);
      $story_image->story_id = $story->id;
      $story_image->save();
    }
    return redirect()->route('admin.story.index')->with('success', 'Story Created successfully');
  }

  public function uploadFile($value)
  {
    $file = $value;
    $fileName = time() . '_' . rand(0, 500) . '_' . $file->getClientOriginalName();
    $fileName = str_replace(' ', '_', $fileName);
    $uploadFile =  $file->storeAs('story_image', $fileName);
    return $uploadFile;
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Model\Story  $story
   * @return \Illuminate\Http\Response
   */
  public function show(Story $story)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Model\Story  $story
   * @return \Illuminate\Http\Response
   */
  public function edit(Story $story)
  {
    $this->data['title'] = 'Edit';
    $this->data['story'] = $story;
    return $this->view('admin.story.edit');
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Model\Story  $story
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, Story $story)
  {

    $story->title = $request->title;
    $story->video_url = $request->video_url;
    $story->instagram_handle = $request->instagram_handle;
    $story->instagram_handle_url = $request->instagram_handle_url;
    $story->description = $request->description;
    $story->save();

    foreach ($request->caption as $key => $value) {
      $story_image = StoryImage::find($request->input('id.' . $key));
      $file = FileUploader::make($request->file('post_image_' . $key, null))->upload('story_image', $story_image->image ?? null);
      $story_image->url = $request->input('url.' . $key);
      $story_image->image = $file;
      $story_image->caption = $request->input('caption.' . $key);
      $story_image->story_id = $story->id;
      $story_image->save();
    }

    return redirect()->route('admin.story.index')->with('success', 'Story Saved successfully');
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Model\Story  $story
   * @return \Illuminate\Http\Response
   */
  public function destroy(Story $story)
  {
    $story->delete();
    return response()->json([
      'success' => true,
      'message' => 'Story Deleted SuccessFully'
    ], 200);
  }
}