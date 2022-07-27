<?php

namespace App\Traits;
use App\Model\ShoppingCart;
use Illuminate\Http\Request;
use Storage;

trait MoveToCart {

    public function move(Request $request, $user) {

        $session_id = \Session::get('cart_session');

        $userId = $user->id;

        if ($session_id) {
            $currentSessionProduct = ShoppingCart::where('session_id', $session_id)->get();
        }

        if (isset($currentSessionProduct) && $currentSessionProduct->count() > 0) {

            foreach ($currentSessionProduct as $key => $sessionProduct) {

                $variantExist = ShoppingCart::where('product_id', $sessionProduct->product_id)
                    ->where('variant_id', $sessionProduct->variant_id)
                    ->where('user_id', $userId)->first();

                if ($variantExist) {
                    $variantExist->qty = $variantExist->qty + $sessionProduct->qty;
                    $variantExist->save();
                    $sessionProduct->delete();
                    continue;
                }

                $sessionProduct->user_id = $userId;
                $sessionProduct->session_id = null;
                $sessionProduct->save();

            }

            \Session::put('cart_session',null);

        }
    }

}
