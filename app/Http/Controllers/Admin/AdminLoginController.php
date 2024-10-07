<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminLoginController extends Controller
{
  public function showLoginForm()
  {
    return view('admin.login');
  }

  public function login(Request $request)
  {
    $request->validate([
      'email' => 'required|email',
      'password' => 'required',
    ]);

    $credentials = $request->only('email', 'password');

    if (Auth::attempt($credentials)) {
      if (Auth::user()->role_id === 1) {
        return redirect()->intended('admin');
      }

      Auth::logout();
      return back()->withErrors(['email' => 'You are not authorized.']);
    }

    return back()->withErrors(['email' => 'Invalid credentials.']);
  }

  public function logout()
  {
    Auth::logout();
    return redirect('/admin/login');
  }
}
