<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
  public function authenticate(Request $request)
  {
      $credentials = $request->validate([
      'email' => 'required|email',
      'password' => 'required'
      ]);
      $remember = $request->has('remember-me');
      if (Auth::attempt($credentials, $remember)) {
          $request->session()->regenerate();
          return response()->json(['user' => Auth::user()]);
      }
      return response()->json(['user' => null], 401);
  }
  
    public function logout(Request $request)
    {
      Auth::logout();
      $request->session()->invalidate();
      $request->session()->regenerateToken();
      return response()->json(['success' => 'Utilisateur deconnecté !']);
    }
}
