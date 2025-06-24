<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{

    public function login()
    {
        if (session()){
            redirect()->back();
        }
        return view('login');
    }

    
    // $request->validate([
            //     'nip' => 'required',
            //     'password'=> 'required' 
            // ], [
            //     'nip.required' => 'NIP is required',
            //     'password.required' => 'Password is required',
            // ]);
    public function signin(Request $request)
{
    $request->validate([
        'nip' => 'required',
        'password'=> 'required' 
    ]);

    if (Auth::attempt($request->only('nip','password'))) {
        if (Auth::user()->role == 'admin') {
            Auth::guard('admin')->login(Auth::user());
        }
        else if (Auth::user()->role == 'supervisi') {
            Auth::guard('supervisi')->login(Auth::user());
        }
        else if (Auth::user()->role == 'petugas') {
            Auth::guard('petugas')->login(Auth::user());
        }

        $request->session()->regenerate();

        return redirect()->route('pelatihan-berlangsung')->with('success', 'Anda berhasil login');
    }
    else
    {
        return redirect('/login')->with('error', 'Invalid NIP or Password')->withInput($request->except('password'));
    }
}

    public function logout(Request $request)
    {

        if (Auth::guard('admin')->check()) {
            Auth::guard('admin')->logout();
        } elseif (Auth::guard('supervisi')->check()) {
            Auth::guard('supervisi')->logout();
        } elseif (Auth::guard('petugas')->check()) {
            Auth::guard('petugas')->logout();
        }
    
        $request->session()->invalidate();
    
        return redirect('/login')->with('success', 'Anda berhasil logout');
    }

}