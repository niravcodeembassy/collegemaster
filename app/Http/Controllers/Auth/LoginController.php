<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Model\ShoppingCart;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Traits\MoveToCart;

class LoginController extends Controller
{
  /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

  use AuthenticatesUsers;
  use MoveToCart;

  /**
   * Where to redirect users after login.
   *
   * @var string
   */
  protected $redirectTo = '/';


  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {
    $this->middleware('guest')->except('logout');
  }

  public function logout(Request $request)
  {

    $this->guard()->logout();

    $request->session()->invalidate();

    $locale = request()->segment(1);
    $url = '/';
    if (in_array($locale, config('app.locales'))) {
      $url = $locale;
    }

    return $this->loggedOut($request) ?:  redirect($url);
  }

  public function showLoginForm()
  {
    session(['link' => url()->previous()]);
    return view('auth.login');
  }

  protected function authenticated(Request $request, $user)
  {
    $this->move($request, $user);
    return redirect(session('link'));
    $locale = request()->segment(1);
    $url = '/';
    if (in_array($locale, config('app.locales'))) {
      $url = '/' . $locale;
    }
    return  redirect($url);
  }
}