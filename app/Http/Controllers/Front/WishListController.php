<?php
namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Model\WishList;
use Auth ;
use App\Model\Product ;
use Illuminate\Http\Request;

class WishListController extends Controller
{
    //
    public function index(Request $request)
    {
        $this->data['title'] = 'WishList' ;

        // dd($variant->product_id);

        \Config::set('database.connections.mysql.strict', false); \DB::reconnect();

        $buytogetherproducts =  Product::productList(false)->inRandomOrder()->where('wish.user_id' , Auth::user()->id)->orderBy('products.id' , 'DESC')->paginate(9);;
        // dd($buytogetherproducts);
        $this->data['buytogetherproducts'] = $buytogetherproducts ;

        \Config::set('database.connections.mysql.strict', true); \DB::reconnect();

        return view('frontend.dashboard.wishlist' , $this->data);
    }

    public function addWishList(Request $request) {

        if (Auth::user()) {

            $userId = Auth::user()->id;
            $find = WishList::where('variant_id',$request->variant_id)->where('user_id', $userId)->first();
            if (!$find) {

                $newWishList = new WishList();
                $newWishList->variant_id = $request->variant_id ;
                $newWishList->user_id = \Auth::id();
                $newWishList->save() ;

                return response()->json([
                    'process' => "add",
                    'success' => true,
                    'message' => 'add  successfully.'
                ], 200);

            } else {

                $wishLiIst = WishList::where('variant_id'  , $request->variant_id)->where('user_id' , \Auth::id())->delete();

                return response()->json([
                    'process' => "remove",
                    'success' => true,
                    'message' => 'remove successfully.'
                ], 200);


            }
        }

    }



}
