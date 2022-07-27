<?php

namespace App\Http\Controllers\Admin;

use App\Model\Discount;
use App\Http\Requests\DiscountValidation;
use App\Model\Product;
use App\Traits\DatatableTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Order;

class DiscountController extends Controller
{
    use DatatableTrait ;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->data['title'] =  'Discount' ;
        return view('admin.discount.index' , $this->data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $this->data['title'] =  'Discount' ;
        return view('admin.discount.create' , $this->data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $coupon = new Discount();

        $start_date = Carbon::parse($request->start_date)->format('Y-m-d');
        $end_date = Carbon::parse($request->end_date)->format('Y-m-d');

        $coupon->discount_code = $request->discount_code;
        $coupon->discount_type = $request->discount_type;

        if ($coupon->discount_type == 'amount') {
            $coupon->discount =  $request->amount ;
        }else {
            $coupon->discount = $request->percentage ;
        }

        $coupon->applies_to = $request->applies_to;

        // $coupon->collection_list = $request->collection_list;
        $coupon->minimum_requirement = $request->minimum_requirement;
        $coupon->min_amount = $request->min_purchase_amount;

        $coupon->start_date = $start_date;
        $coupon->end_date = $end_date;

        $coupon->save();

        if ($request->applies_to == 'product') {
            $coupon->products()->sync($request->applies_to_product);
        } else if ($request->applies_to == 'category') {
            $coupon->categories()->sync($request->applies_to_category);
        }

        return redirect()->route('admin.discount.index')->with('success',__('discount.add_discount'));

    }

    public function dataListing(Request $request)
    {

        // Listing colomns to show
        $columns = array(
            0 => 'id',
            1 => 'discount_code',
            2 => 'start_date',
            3 => 'end_date',
            4 => 'id',
            5 => 'is_active',
            6 => 'action',
        );


        $totalData = Discount::count(); // datata table count

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');
        $search = $request->input('search.value');

        // dd($request);

        // DB::enableQueryLog();
        // genrate a query
        $customcollections = Discount::when($search, function ($query, $search) {
            return $query->where('code', 'LIKE', "%{$search}%");
        });

        // dd($totalData);

        $totalFiltered = $customcollections->count();

        $customcollections = $customcollections->offset($start)->limit($limit)->orderBy($order, $dir)->get();

        $data = [];
        // dd($customcollections);
        foreach ($customcollections as $key => $item) {

            // dd(route('admin.brand.edit', $item->id));
            $row['id'] = $item->id;
            $row['code'] = '<div class="text-center"><span class="badge badge-pill badge-primary mb-1">'.$item->discount_code.'</span></div>';
            $row['start_date'] = $item->start_date->format('d-m-Y');
            $row['end_date'] = $item->end_date->format('d-m-Y');
            $row['noOfUse'] = 0;
            $row['status'] = $this->status( $item->is_active , $item->id , route('admin.discount.status')) ;
            $row['action'] = $this->action([
                collect([
                    'text' => 'Edit' ,
                    'action' => route('admin.discount.edit', $item->id) ,
                    'id' =>  $item->id ,
                    'icon' => 'fa fa-pen',
                    'permission' => true
                ]),
                collect([
                    'text' => 'Delete' ,
                    'action' => route('admin.discount.destroy', $item->id) ,
                    'id' =>  $item->id ,
                    'icon' => 'fa fa-trash',
                    'class' => 'delete-confirmation',
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
     * @param  \App\Model\Discount  $discount
     * @return \Illuminate\Http\Response
     */
    public function show(Discount $discount)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Discount  $discount
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request ,$id)
    {
        $coupon = Discount::discountItem()->findOrfail($id);
        // dd($coupon);
        $this->data['coupon'] = $coupon ;
        $this->data['title'] =  'Edit' ;
        return view('admin.discount.edit' , $this->data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Discount  $discount
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        //

        $coupon = Discount::discountItem()->findOrfail($id);

        $start_date = Carbon::parse($request->start_date)->format('Y-m-d h:i:s');
        $end_date = Carbon::parse($request->end_date)->format('Y-m-d h:i:s');

        $coupon->discount_code = $request->discount_code;
        $coupon->discount_type = $request->discount_type;
        // $coupon->discount = $request->percentage ?? $request->amount ;
        if ($coupon->discount_type == 'amount') {
            $coupon->discount =  $request->amount ;
        }else {
            $coupon->discount = $request->percentage ;
        }

        $coupon->applies_to = $request->applies_to;

        // $coupon->collection_list = $request->collection_list;
        $coupon->minimum_requirement = $request->minimum_requirement;
        $coupon->min_amount = $request->min_purchase_amount;

        $coupon->start_date = $start_date;
        $coupon->end_date = $end_date;
        $coupon->save();
        // dd($coupon,$request);

        $coupon->categories()->detach(); // remov all collection
        $coupon->products()->detach(); // remov all product

        if ($request->applies_to == 'product') {
            $coupon->products()->sync($request->applies_to_product);
        } else if ($request->applies_to == 'category') {
            $coupon->categories()->sync($request->applies_to_category);
        }

        return redirect()->route('admin.discount.index')->with('success',__('discount.update_discount'));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Discount  $discount
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $statuscode = 400 ;

        $discount = Discount::findOrFail($id);
        //$discount->categories()->detach(); // remov all collection
        $discount->products()->detach(); // remov all product

        if($discount->delete()) {
            $statuscode = 200 ;
        }

        return response()->json([
            'success' => true ,
            'message' => __('discount.delete_discount'),
        ],$statuscode);
    }


    public function changeStatus(Request $request)
    {
        $slider = Discount::findOrFail($request->id);
        $slider->is_active  = $request->status == 'true' ? null : date('Y-m-d H:i:s');
        if ($slider->save()) {
            $statuscode = 200;
        }

        $status = $request->status == 'true' ? 'active' : 'deactivate';
        $message = 'Discount ' . $status . ' successfully.';

        return response()->json([
            'success' => true,
            'message' => $message
        ], $statuscode);
    }

    public function checkDiscountCode(Request $request){

        // dd($request->all());

        $discount = Discount::when($request->id ,function($query, $id) {

            $query->where('id','!=', $id );

        })->where('discount_code','=',$request->get('discount_code') )->first();

        if (is_null($discount)) {

            return 'true';
        }
        return 'false';
    }

}
