<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\FrequentAskQuestion;
use Illuminate\Http\Request;
use App\Traits\DatatableTrait;

class FrequentAskQuestionController extends Controller
{
  use DatatableTrait;
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $this->data['title'] = 'Frequent Ask Question';
    return $this->view('admin.faq.index');
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    $faqs = FrequentAskQuestion::all();
    $this->data['title'] = 'Create Faq Question';
    $this->data['faq'] = $faqs;
    return $this->view('admin.faq.create');
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    $question = FrequentAskQuestion::updateOrCreate(['id' => $request->question_id, 'parent_id' => null], [
      'title' => $request->title,
    ]);

    $old = collect($request->input('response'))->whereNotNull('parent_id')->pluck('parent_id');
    $latest = collect($request->input('response'))->whereNull('parent_id')->pluck('parent_id');

    if ($old->count() > 0 || $latest->count() > 0) {
      FrequentAskQuestion::whereNotIn('id', $old)->where('parent_id', '=', $question->id ?? null)->forceDelete();
    }

    foreach ($request->input('response', []) as $item) {
      $data = [
        'title' => $request->title,
        'question' => $item['question'],
        'answer' => $item['answer'],
        'parent_id' => $question->id,
      ];
      //update or create
      FrequentAskQuestion::updateOrCreate(['id' => $item['parent_id']], $data);
    }

    return redirect()->route('admin.faq.index')->with('success', 'Faq Question Created successfully');
  }

  public function dataListing(Request $request)
  {
    // Listing columns to show
    $columns = array(
      0 => 'id',
      1 => 'title',
      2 => 'action',
    );


    $totalData = FrequentAskQuestion::count(); // datatatable count

    $limit = $request->input('length');
    $start = $request->input('start');
    $order = $columns[$request->input('order.0.column')];
    $dir = $request->input('order.0.dir');
    $search = $request->input('search.value');

    // dd($request);

    // DB::enableQueryLog();
    // generate a query
    $featureCollection = FrequentAskQuestion::whereNull('parent_id')->when($search, function ($query, $search) {
      return $query->where('title', 'LIKE', "%{$search}%");
    });

    $totalData = $featureCollection->count(); // datatable count
    // dd($totalData);

    $totalFiltered = $featureCollection->count();

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
          'action' => route('admin.faq.edit', ['faq' => $item->id]),
          'icon' => 'fa fa-pen',
          'permission' => false
        ]),
        collect([
          'text' => 'Delete',
          'id' => $item->id,
          'action' => route('admin.faq.destroy', ['faq' => $item->id]),
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
   * Display the specified resource.
   *
   * @param  \App\Model\FrequentAskQuestion  $frequentAskQuestion
   * @return \Illuminate\Http\Response
   */
  public function show(FrequentAskQuestion $frequentAskQuestion)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Model\FrequentAskQuestion  $frequentAskQuestion
   * @return \Illuminate\Http\Response
   */
  public function edit(FrequentAskQuestion $faq)
  {

    $this->data['title'] = 'Edit Frequent Ask Question';
    $this->data['faq'] = $faq;
    return $this->view('admin.faq.edit');
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Model\FrequentAskQuestion  $frequentAskQuestion
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, FrequentAskQuestion $frequentAskQuestion)
  {
    $question = FrequentAskQuestion::updateOrCreate(['id' => $request->question_id, 'parent_id' => null], [
      'title' => $request->title,
    ]);

    $old = collect($request->input('response'))->whereNotNull('parent_id')->pluck('parent_id');
    $latest = collect($request->input('response'))->whereNull('parent_id')->pluck('parent_id');
    // dd($old, $latest);
    FrequentAskQuestion::whereNotIn('id', $old)->where('parent_id', '=', $question->id ?? null)->forceDelete();

    foreach ($request->input('response', []) as $item) {
      $data = [
        'title' => $request->title,
        'question' => $item['question'],
        'answer' => $item['answer'],
        'parent_id' => $question->id,
      ];
      //update or create
      FrequentAskQuestion::updateOrCreate(['id' => $item['parent_id']], $data);
    }

    return redirect()->route('admin.faq.index')->with('success', 'Faq Update successfully');
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Model\FrequentAskQuestion  $frequentAskQuestion
   * @return \Illuminate\Http\Response
   */
  public function destroy(FrequentAskQuestion $faq)
  {
    $id = $faq->id;
    FrequentAskQuestion::where('id', $id)->delete();

    return response()->json([
      'success' => true,
      'message' => 'Faq Deleted SuccessFully'
    ], 200);
  }
}