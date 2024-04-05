<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
  public function index()
  {
    $pageConfigs = ['myLayout' => 'blank'];
    return view('content.authentications.auth-login-basic', ['pageConfigs' => $pageConfigs]);
  }

  public function login(Request $request)
  {
    $user = User::where('email', $request->email)->first();
    if ($user && Hash::check($request->password, $user->password)) {
      $request->session()->regenerate();
      return redirect()->route('home');
    }

    return back()->withErrors([
      'email' => 'The provided credentials do not match our records.',
    ])->withInput();
  }
}
