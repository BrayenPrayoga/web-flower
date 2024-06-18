<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Hash;

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
            $request->session()->flash('error', 'Gagal Login, SIlahkan Periksa Email dan Password Anda!');
            return redirect()->intended('/');
        }
  
        $request->session()->flash('error', 'Login Gagal!');
        return redirect()->back()->with(['error'=>'Login Gagal']);
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
  
    public function resetPassword($id){
        $data['user'] = User::where('id', $id)->first();

        return view('reset_password', $data);
    }

    public function updatePassword(Request $request){
        $request->validate([
            'email'=>'required',
            'password'=>'required',
            'confirm_password'=>'required|same:password'
        ]);
        $password = Hash::make($request->password);
        $update = User::where('id', $request->id)->update(['password'=>$password]);
        
        $request->session()->flash('success', 'Reset Berhasil, SIlahkan Login');
        return redirect('/');
    }
}
