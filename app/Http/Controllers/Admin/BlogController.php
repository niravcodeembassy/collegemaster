<?php

namespace App\Http\Controllers\Admin;

use App\Blog;
use Aj\FileUploader\FileUploader;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\DatatableTrait;

class BlogController extends Controller
{
  use DatatableTrait;
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $this->data['title'] = 'Blog';
    return $this->view('admin.blog.index');
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    $this->data['title'] = 'Create';
    return $this->view('admin.blog.create');
  }

  public function dataList(Request $request)
  {
    // Listing colomns to show
    $columns = array(
      0 => 'id',
      1 => 'title',
      2 => 'created_at',
      4 => 'action',
    );


    $totalData = Blog::count(); // datata table count

    $limit = $request->input('length');
    $start = $request->input('start');
    $order = $columns[$request->input('order.0.column')];
    $dir = $request->input('order.0.dir');
    $search = $request->input('search.value');

    // genrate a query
    $customcollections = Blog::when($search, function ($query, $search) {
      return $query->where('title', 'LIKE', "%{$search}%")->orWhere('slug', 'LIKE', "%{$search}%");
    });

    $totalFiltered = $customcollections->count();

    $customcollections = $customcollections->offset($start)->limit($limit)->orderBy($order, $dir)->get();

    $data = [];

    // dd($customcollections);
    foreach ($customcollections as $key => $item) {
      // dd(route('admin.brand.edit', $item->id));
      $row['id'] = $item->id;
      $row['title'] = '<b>' . $item->title . '</b>';
      $row['created_at'] = date("d-m-Y", strtotime($item->created_at));
      $row['status'] = $this->status($item->is_active, $item->id, route('admin.blog.status', ['id' => $item->id]));
      $row['action'] = $this->action([
        collect([
          'text' => 'Edit',
          'id' => $item->id,
          'action' => route('admin.blog.edit', $item->id),
          'icon' => 'fa fa-pen',
          'permission' => true
        ]),
        collect([
          'text' => 'Delete',
          'id' => $item->id,
          'action' => route('admin.blog.destroy', ['blog' => $item->id]),
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
    $blog = new Blog();
    $blog->title = $request->title;
    $blog->slug = $request->slug;
    $blog->content = $request->content;
    $blog->description = $request->description;
    $blog->published_at = now()->format('Y-m-d H:i:s');
    $blog->meta_title    = $request->meta_title ?? $request->title;
    $blog->meta_description     = $request->meta_description;
    $blog->meta_keywords = $request->meta_keywords;
    $blog->handle        = $request->slug;
    $blog->image = FileUploader::make($request->images)->upload('blog');
    $blog->save();

    $blog->tags()->sync($request->tag);

    return redirect()->route('admin.blog.index')->with('success', 'Blog Created Successfully');
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Blog  $blog
   * @return \Illuminate\Http\Response
   */
  public function show(Blog $blog)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Blog  $blog
   * @return \Illuminate\Http\Response
   */
  public function edit(Blog $blog)
  {
    $this->data['title'] = 'Edit';
    $this->data['blog'] = $blog;
    return $this->view('admin.blog.edit');
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Blog  $blog
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, Blog $blog)
  {
    $blog->title = $request->title;
    $blog->slug = $request->slug;
    $blog->content = $request->content;
    $blog->description = $request->description;
    $blog->meta_title    = $request->meta_title ?? $request->title;
    $blog->meta_description     = $request->meta_description;
    $blog->meta_keywords = $request->meta_keywords;
    $blog->handle        = $request->slug;
    $blog->image = FileUploader::make($request->images)->upload('blog', $blog->image);
    $blog->save();

    $blog->tags()->sync($request->tag);

    return redirect()->route('admin.blog.index')->with('success', 'Blog Updated Successfully');
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Blog  $blog
   * @return \Illuminate\Http\Response
   */
  public function destroy(Blog $blog)
  {

    $blog->delete();

    return response()->json([
      'success' => true,
      'message' => 'Blog Deleted SuccessFully'
    ], 200);
  }

  public function changeStatus(Request $request, $id)
  {
    $blog = Blog::findOrFail($request->id);
    $blog->is_active  = $request->status == 'true' ? null :  date('Y-m-d H:i:s');

    if ($blog->save()) {
      $statuscode = 200;
    }

    $status = $request->status == 'true' ? 'active' : 'deactivate';
    $message = "Blog $status successfully.";

    return response()->json([
      'success' => true,
      'message' => $message
    ], $statuscode ?? 400);
  }


  public function exists(Request $request)
  {

    $id = $request->get('id');

    $count = Blog::when($id != null, function ($query) use ($request) {
      return $query->where('id', '!=', $request->id);
    })->where('title', $request->title)->count();

    if ($count > 0) {
      return 'false';
    } else {
      return 'true';
    }
  }
}