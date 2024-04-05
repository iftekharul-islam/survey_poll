<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
  public function login()
  {
    $pageConfigs = ['myLayout' => 'blank'];
    return view('content.authentications.auth-login-basic', ['pageConfigs' => $pageConfigs]);
  }

  public function loginConfirm(Request $request)
  {
    $request->validate([
      'email' => 'required|email',
      'password' => 'required|min:6'
    ]);
    $credentials = $request->only('email', 'password');
    if (Auth::attempt($credentials)) {
      return redirect()->route('home');
    }
    return redirect()->route('login')
      ->with('error', 'Invalid login credentials')->withInput();
  }

  public function logout(Request $request)
  {
    Auth::logout();
    $request->session()->invalidate();
    return redirect()->route('login');
  }
}
