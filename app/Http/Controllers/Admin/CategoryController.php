<?php

namespace App\Http\Controllers\Admin;

use Aj\FileUploader\FileUploader;
use App\Category;
use App\Http\Controllers\Controller;
use App\Traits\DatatableTrait;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
  use DatatableTrait;
  public function index()
  {
    $this->data['title'] = 'Category';
    return $this->view('admin.categories.index');
  }


  public function create()
  {
    $this->data['title'] = 'Create';
    return $this->view('admin.categories.create');
  }


  public function dataList(Request $request)
  {
    // Listing colomns to show
    $columns = array(
      0 => 'id',
      1 => 'name',
      3 => 'action',
    );


    $totalData = Category::count(); // datata table count

    $limit = $request->input('length');
    $start = $request->input('start');
    $order = $columns[$request->input('order.0.column')];
    $dir = $request->input('order.0.dir');
    $search = $request->input('search.value');

    // dd($request);

    // DB::enableQueryLog();
    // genrate a query
    $customcollections = Category::when($search, function ($query, $search) {
      return $query->where('description', 'LIKE', "%{$search}%")->orWhere('name', 'LIKE', "%{$search}%");
    });

    // dd($totalData);

    $totalFiltered = $customcollections->count();

    $customcollections = $customcollections->offset($start)->limit($limit)->orderBy($order, $dir)->get();

    $data = [];
    // dd($customcollections);
    foreach ($customcollections as $key => $item) {

      // dd(route('admin.brand.edit', $item->id));
      $row['id'] = $item->id;
      $row['name'] = '<b>' . $item->name . '</b>';
      $row['status'] = $this->status($item->is_active, $item->id, route('admin.category.status', ['id' => $item->id]));
      $row['permission'] = $this->permition($item->id);
      $row['action'] = $this->action([
        collect([
          'text' => 'Edit',
          'id' => $item->id,
          'action' => route('admin.category.edit', $item->id),
          'icon' => 'fa fa-pen',
          'permission' => true
        ]),
        collect([
          'text' => 'Delete',
          'id' => $item->id,
          'action' => route('admin.category.destroy', ['category' => $item->id]),
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
    $category = new Category();
    $category->name = $request->name;
    $category->slug = $request->slug;
    $category->description = $request->description;
    $category->meta_title    = $request->meta_title ?? $request->title;
    $category->meta_description     = $request->meta_description;
    $category->meta_keywords = $request->meta_keywords;
    $category->handle        = $request->handle;
    $category->image = FileUploader::make($request->images)->upload('category');
    $category->save();

    return redirect()->route('admin.category.index')->with('success', 'Category Created Successfully');
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Category  $category
   * @return \Illuminate\Http\Response
   */
  public function show(Category $category)
  {
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Category  $category
   * @return \Illuminate\Http\Response
   */
  public function edit(Category $category)
  {
    $this->data['title'] = 'Edit';
    $this->data['category'] = $category;
    return $this->view('admin.categories.edit');
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Category  $category
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, Category $category)
  {

    $category->name = $request->name;
    $category->slug = $request->slug;
    $category->description = $request->description;
    $category->meta_title    = $request->meta_title ?? $request->title;
    $category->meta_description     = $request->meta_description;
    $category->meta_keywords = $request->meta_keywords;
    $category->handle        = $request->handle;
    $category->image = FileUploader::make($request->images)->upload('category', $category->image);
    $category->save();
    return redirect()->route('admin.category.index')->with('success', 'Category Updated Successfully');
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Category  $category
   * @return \Illuminate\Http\Response
   */
  public function destroy(Category $category)
  {

    $category->delete();

    return response()->json([
      'success' => true,
      'message' => 'Category Deleted SuccessFully'
    ], 200);
  }

  public function changeStatus(Request $request, $id)
  {
    $category = Category::findOrFail($request->id);
    $category->is_active  = $request->status == 'true' ? null :  date('Y-m-d H:i:s');

    if ($category->save()) {
      $statuscode = 200;
    }

    $status = $request->status == 'true' ? 'active' : 'deactivate';
    $message = "Category $status successfully.";

    return response()->json([
      'success' => true,
      'message' => $message
    ], $statuscode ?? 400);
  }


  public function exists(Request $request)
  {

    $id = $request->get('id');

    $count = Category::when($id != null, function ($query) use ($request) {
      return $query->where('id', '!=', $request->id);
    })->where('name', $request->name)->count();

    if ($count > 0) {
      return 'false';
    } else {
      return 'true';
    }
  }
}