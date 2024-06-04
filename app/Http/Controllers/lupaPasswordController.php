<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;

class lupaPasswordController extends Controller
{
    public function index()
    {
        return view('lupaPassword');
    }

    public function ubahPassword(Request $request)
    {
        $data = $request->validate([
            'username' => 'required|min:6',
        ]);

        if(strlen($request->password) < 6 ){
            return back()->with('password<6','');
        }

        $user = User::all();
        foreach ($user as $value) {
            if ($value->username == $data['username']) {
                $data['backup_password'] = $request->password;
                $data['password'] = Hash::make($data['backup_password']);
                $user = User::where('username', '=', $data['username'])
                    ->get()
                    ->first();
                $user->update([
                    'password' => $data['password'],
                    'backup_password' => $data['backup_password'],
                ]);
                return  redirect()->route('home')->with('success_ubah_password','');
            }
            
        }
        return back()->with('no_username', '');
    }
}
