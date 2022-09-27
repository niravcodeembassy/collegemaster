<?php

namespace App\Http\Controllers\Admin;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\ProductReview;
use App\Traits\DatatableTrait;
use Carbon\Carbon;

class ReviewController extends Controller
{
  //
  use DatatableTrait;


  public function index()
  {
    $this->data['title'] = 'Reviews';
    return view('admin.review.index', $this->data);
  }

  public function create()
  {
    $this->data['title'] = 'Create';
    return view('admin.review.create', $this->data);
  }

  public function store(Request $request)
  {
    $date = date_create($request->created_date);
    $date = date_format($date, "Y/m/d H:i:s");
    $created_date = Carbon::parse($date)->format('Y-m-d h:i:s');
    $review = new ProductReview();
    $review->user_id = $request->user;
    $review->product_id = $request->product;
    $review->name = $request->name;
    $review->email = $request->email;
    $review->rating = $request->rating ?? 1;
    $review->message = $request->message;
    $review->created_at = $created_date;
    $review->save();
    return redirect()->route('admin.review.index')->with('success', 'Review Added Successfully');
  }



  public function dataListing(Request $request)
  {

    // Listing colomns to show
    $columns = array(
      'name',
      'product_id',
      'email',
      'rating',
      'action',
    );


    $totalData = ProductReview::count(); // datata table count

    $limit = $request->input('length');
    $start = $request->input('start');
    $order = $columns[$request->input('order.0.column')];
    $dir = $request->input('order.0.dir');
    $search = $request->input('search.value');

    // dd($request);

    // DB::enableQueryLog();
    // genrate a query
    $customcollections = ProductReview::with(['product', 'user'])->when($search, function ($query, $search) {
      return $query->whereLike(['user.name', 'user.email', 'product.name'], $search)->orWhere('name', 'LIKE', "%{$search}%")->orWhere('email', 'LIKE', "%{$search}%");
    });

    // dd($totalData);

    $totalFiltered = $customcollections->count();

    $customcollections = $customcollections->offset($start)->limit($limit)->orderBy($order, $dir)->get();

    $data = [];
    // dd($customcollections);
    foreach ($customcollections as $key => $item) {

      $row['name']   =  $item->name == null ? $item->user->name : $item->name;
      $row['product']  = $item->product->name;
      $row['email']  = $item->email == null ? $item->user->email : $item->email;
      $row['review']  = $this->text($item->rating . ' <i class="fa fa-star"></i>');
      $row['status'] = $this->status($item->is_active, $item->id, route('admin.review.status'));
      $row['action'] = $this->action([
        collect([
          'text' => 'Edit',
          'id' => $item->id,
          'action' => route('admin.review.edit', $item->id),
          'icon' => 'fa fa-pen',
          'permission' => true
        ]),
        collect([
          'text' => 'Delete',
          'action' => route('admin.review.destroy', $item->id),
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

  public function edit($id)
  {
    $review = ProductReview::find($id);
    $this->data['title'] = 'Edit';
    $this->data['review'] = $review;
    return $this->view('admin.review.edit');
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Blog  $blog
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, $id)
  {
    $date = date_create($request->created_date);
    $date = date_format($date, "Y/m/d H:i:s");
    $created_date = Carbon::parse($date)->format('Y-m-d h:i:s');
    $review = ProductReview::find($id);
    $review->user_id = $request->user;
    $review->product_id = $request->product;
    $review->name = $request->name;
    $review->email = $request->email;
    $review->rating = $request->rating;
    $review->message = $request->message;
    $review->created_at = $created_date;
    $review->save();
    return redirect()->route('admin.review.index')->with('success', 'Review Updated Successfully');
  }

  public function changeStatus(Request $request)
  {

    $statuscode = 400;
    $slider = ProductReview::findOrFail($request->id);
    $slider->is_active  =  $request->status == 'true' ? null :  date('Y-m-d H:i:s');

    if ($slider->save()) {
      $statuscode = 200;
    }
    $status = $request->status == 'true' ? 'active' : 'deactivate';
    $message = 'Review ' . $status . ' successfully.';

    return response()->json([
      'success' => true,
      'message' => $message
    ], $statuscode);
  }

  public function destroy(Request $request, $id)
  {
    try {


      $inShoppingCart = ProductReview::where('id', $id)->delete();

      return response()->json([
        'success' => true,
        'message' => 'Review deleted successfully'
      ], 200);
    } catch (\Exception $e) {

      return response()->json([
        'success' => false,
        'message' => 'Review associate with user cart !'
      ], 406);
    }
  }
}