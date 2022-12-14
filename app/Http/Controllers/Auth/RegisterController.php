<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Traits\MoveToCart;
use App\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\SignUp;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
  /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

  use RegistersUsers;
  use MoveToCart;


  /**
   * Where to redirect users after registration.
   *
   * @var string
   */
  protected $redirectTo = RouteServiceProvider::HOME;

  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {
    $this->middleware('guest');
  }



  /**
   * Show the application registration form.
   *
   * @return \Illuminate\View\View
   */
  public function showRegistrationForm()
  {
    return view('auth.register',['title'=>'Register']);
  }

  /**
   * Get a validator for an incoming registration request.
   *
   * @param  array  $data
   * @return \Illuminate\Contracts\Validation\Validator
   */
  protected function validator(array $data)
  {
    return Validator::make($data, [
      'first_name' => ['required', 'string', 'max:255'],
      'last_name' => ['required', 'string', 'max:255'],
      'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
      'password' => ['required', 'string', 'min:8', 'confirmed'],
    ]);
  }

  /**
   * Create a new user instance after a valid registration.
   *
   * @param  array  $data
   * @return \App\User
   */
  protected function create(array $data)
  {
    $mobile = $data['country_code'] . "" . $data['mobile'];
    $user =  User::create([
      'name' => $data['first_name'] . " " . $data['last_name'],
      'first_name' => $data['first_name'],
      'last_name' => $data['last_name'],
      'country_code' => $data['country_code'],
      'country_id' => $data['country_id'],
      'phone' => $mobile,
      'email' => $data['email'],
      'password' => Hash::make($data['password']),
    ]);

    try {
      Mail::to($user->email)->send(new SignUp($user));
    } catch (\Exception $th) {
    }

    return $user;
  }

  /**
   * The user has been registered.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  mixed  $user
   * @return mixed
   */
  protected function registered(Request $request, $user)
  {
    // \Auth::logout();
    $this->move($request, $user);
    if (session('link') != null) {
      return redirect(session('link'));
    } else {
      return redirect()->route('login')->with('success', "You have Successfully Registered");
    }
  }
}