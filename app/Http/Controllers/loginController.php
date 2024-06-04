<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class loginController extends Controller
{
    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required|min:5',
            'password' => 'required|min:5',
        ]);

        if (Auth::attempt($credentials)) {
            
            $request->session()->regenerate();
            return redirect()->intended(route('beranda', '1'))->with('success', '');

        }
        return back()->with('loginError', '');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();
        return redirect('/')->with('success_logout', '');
    }
}
