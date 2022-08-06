<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\Story;
use App\Model\StoryImage;
use Illuminate\Http\Request;
use App\Traits\DatatableTrait;
use Illuminate\Support\Facades\DB;

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
        collect([
          'text' => 'Delete',
          'id' => $item->id,
          'action' => route('admin.story.destroy', ['story' => $item->id]),
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
    $story->description = $request->description;
    $story->save();

    try {

      DB::beginTransaction();

      $uploadedFile = [];

      if ($request->hasFile('images')) {

        foreach ($request->file('images', []) as $key => $value) {

          $image = new StoryImage();
          $image->story_id = $story->id;
          $uploadFile =  $this->uploadFile($value);
          $image->image =  $uploadFile;
          $image->image_name =  \Str::after($uploadFile, 'story_image/');

          $image->save();
          $uploadedFile[] = [
            'image_id' => $image->id,
            'uuid' => \Str::uuid()
          ];
        }
      }


      DB::commit();
    } catch (\Exception $e) {
      report($e);

      DB::rollback();

      return redirect()->back()->with('error', 'Something went wrong please try again.');
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
    $this->data['title'] = 'Edit Faq';
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
    $story->description = $request->description;
    $story->save();

    $preloaded = $request->preloaded;
    if (isset($preloaded) && count($preloaded) > 0) {
      $get_image = StoryImage::whereNotIn('id', $preloaded)->where('story_id', $story->id)->get();
      foreach ($get_image->pluck('image') as $path) {
        $imageExist  = $path && \Storage::exists($path);
        if ($imageExist && $path != NULL && $path != "") {
          \Storage::delete($path);
        }
      }
      $delete_image = StoryImage::whereNotIn('id', $preloaded)->where('story_id', $story->id)->delete();
    }

    try {

      DB::beginTransaction();

      $uploadedFile = [];

      if ($request->hasFile('images')) {

        foreach ($request->file('images', []) as $key => $value) {

          $image = new StoryImage();
          $image->story_id = $story->id;
          $uploadFile =  $this->uploadFile($value);
          $image->image =  $uploadFile;
          $image->image_name =  \Str::after($uploadFile, 'story_image/');

          $image->save();
          $uploadedFile[] = [
            'image_id' => $image->id,
            'uuid' => \Str::uuid()
          ];
        }
      }

      DB::commit();
    } catch (\Exception $e) {
      report($e);

      DB::rollback();
      return redirect()->back()->with('error', 'Something went wrong please try again.');
    }

    return redirect()->route('admin.story.index')->with('success', 'Story Updated successfully');
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