<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    //
    public function login(Request $request){
        $request->validate([
            'email'=>'required',
            'password'=>'required'
        ]);
        
        // $credential = $request->only('email','password');

        // if(Auth::attempt($credential)){
        //     $user =  Auth::user();
        //     return redirect()->intended('/dashboard');
        // }
        if (Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password, 'status' => 2])) {
            return redirect()->intended('/dashboard');
        } else {
            return redirect()->intended('/');
        }
  
          return redirect('/')
              ->withInput()
              ->withErrors(['error'=>'Login Gagal']);
       }

    public function logout(Request $request){
        if (Auth::guard('user')->check()) {
            Auth::guard('user')->logout();
        } elseif (Auth::guard('admin')->check()) {
            Auth::guard('admin')->logout();
        } elseif (Auth::guard('web')->check()) {
            Auth::guard('web')->logout();
        }

        return redirect('/');
    }
  
}
