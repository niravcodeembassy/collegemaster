<?php

namespace App\Http\ViewComposers;

use App\Category;
use App\Model\State;
use App\Repository\Contracts\Cart;
use App\Setting;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;


class CommonViewComposer
{
  public $user = null;
  public $frontsetting = null;
  public $forntcategory = null;
  public $cartList = null;
  public $stateList = null;

  /**
   * Bind data to the view.
   *
   * @param  View  $view
   * @return void
   */
  public function compose(View $view)
  {

    if (!$this->frontsetting) {
      $this->frontsetting = Cache::remember('settings', now()->addSecond(600), function () {
        return Setting::first()->response;
      });
    }


    if (!$this->forntcategory) {
      $this->forntcategory = Cache::remember('category', now()->addSecond(600), function () {
        $category = Category::whereNull('is_active')
          ->with(['subCategory' => function ($q) {
            $q->whereNull('is_active');
          }])->get();
        return $category;
      });
    }

    if (!$this->cartList) {
      $cart = app()->make('App\Repository\Contracts\Cart');
      $this->cartList = $cart->get();
    }


    if (!$this->stateList) {
      $state = Cache::rememberForever('stateList', function () {
        return State::where('country_id', 101)->get();
      });;
      $this->stateList = $state;
    }


    $view->with('frontsetting', $this->frontsetting);
    $view->with('forntcategory', $this->forntcategory);
    $view->with('cartList', $this->cartList);
    $view->with('stateList', $this->stateList);
  }
}