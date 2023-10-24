<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class LoginController extends Controller
{
    public function login(){
            return view('pakar.login');
    
    }
    public function actionlogin(Request $request) {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
        $credentials = $request->only('email', 'password');
        $data = DB::table('users')->where('email','=',$request->post('email'))->get();
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            if (auth()->user()->role_id === 1) {
                // jika user superadmin
                return redirect()->intended('/superadmin');
            } else {
                // jika user pegawai
                return redirect()->intended('pakar_dashboard');
            }
        }
 
        return back()->with('error', 'email atau password salah');
    }

    public function actionlogout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login');
    }
}

