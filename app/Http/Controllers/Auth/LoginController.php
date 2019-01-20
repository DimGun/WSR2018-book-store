<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\User;
use Auth;

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


  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {
    $this->middleware('guest')->except('logout');
  }


  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function login(Request $request)
  {
    $credentials = ['email' => $request->login, 'password' => $request->password];
    if(Auth::attempt($credentials)) {
      $authtorizedUser = Auth::user();
      $authtorizedUser->api_token = str_random(60);
      $authtorizedUser->save();
      return $this->makeResponse(200, ['token' => $authtorizedUser->api_token]);
    } else {
      return $this->makeResponse(401, ['message' => 'Invalid authorization data']);
    }
  }

  /**
   * Constructs a uniform response
   * @param int $code -- an HTTP code,
   * @param Array payload -- any additional data that should be passed
   * @return \Illuminate\Http\Response
   */
  protected function makeResponse($code, $payload)
  {
    $status = ($code >= 200 && $code < 300);
    $payload = $payload ?? [];
    $payload['status'] = $status;
    return response()->json($payload, $code);
  }
}
