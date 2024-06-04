<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use RealRashid\SweetAlert\Facades\Alert;

class profileController extends Controller
{
    public function index(){
        $user = User::where('id', '=', auth()->user()->id)->get()->first();
        $password = Hash::check('secret', $user->password);;
        return view('Owner.profil', [
            'active' => "profile",
            'user'  => $user,
            'password' => $password
        ]);
    }

    public function show($id){
        $user = User::where('id', '=', $id)->get()->first();

        return view('Owner.ubahUsername',[
            'active' => "profile",
            'user'  => $user
        ]);
    }
    public function edit($id){
        $user = User::where('id', '=', $id)->get()->first();

        return view('Owner.ubahPassword',[
            'active' => "profile",
            'user'  => $user
        ]);
    }

    public function update_username(Request $request, $id){
        if(strlen($request->username) < 6) {
            return redirect()->back()->with('username<6','');
        }

        $data = $request->validate([
            'username' => 'required|min:6',
        ]);

        $existingUser = User::where('username', $request->username)->where('id', '!=', $id)->first();

        if ($existingUser) {
            return redirect()->back()->with('username_sudah_ada', '');
        }

        $user = User::findOrFail($id);

        $user->update([
            'username' => $data['username']
        ]);


        return redirect()->route('profile.index')->with('success_ubah_username', '');

    }

    public function update_password(Request $request, $id){
        if(strlen($request->password) < 6) {
            return redirect()->back()->with('password<6','');
        }

        $data = $request->validate([
            'password' => 'required|min:6',
        ]);
        

        $user = User::findOrFail($id);

        $data['backup_password'] = $data['password'];
        $data['password'] = Hash::make($data['password']);
        $user->update([
            'password' => $data['password'],
            'backup_password' => $data['backup_password']
        ]);

        return redirect()->route('profile.index')->with('success_ubah_password', '');

    }
}
