<?php

namespace App\Http\Controllers;

use App\Models\DataRole;
use App\Models\DataUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function index()
    {
        $dtUser = DataUser::with('role')->get();
        return view('user.user', compact('dtUser'));
    }


    public function create()
    {
        $dtRole = DataRole::get();
        return view('user.create', compact('dtRole'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'gender' => 'required',
            'role' => 'required',
            'token' => 'required',
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $destinationPath = 'images/';
            $filename = date('YmdHis') . "." . $file->getClientOriginalExtension();
            $file->move($destinationPath, $filename);
            $path = $destinationPath . $filename;
        } else {
            $path = null;
        }

        DataUser::create([
            'User_name' => $request->username,
            'User_email' => $request->email,
            'User_password' => Hash::make($request->password),
            'User_gender' => $request->gender,
            'Role_id' => $request->role,
            'User_token' => $request->token,
            'User_photo' => $path
        ]);

        return redirect()->route('user')->with('success', 'Data stored successfully');
    }

    public function edit($User_id)
    {
        $dtRole = DataRole::get();
        $dtUser = DataUser::where('User_id', $User_id)->with('role')->first();
        return view('user.edit', compact('dtUser', 'dtRole'));
    }

    public function update(Request $request, $User_id)
    {
        $request->validate([
            'username' => 'required',
            'email' => 'required|email',
            'gender' => 'required',
            'role' => 'required',
            'token' => 'required',
            'photo' => 'image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $userData = [
            'User_name' => $request->username,
            'User_email' => $request->email,
            'User_password' => Hash::make($request->password),
            'User_gender' => $request->gender,
            'Role_id' => $request->role,
            'User_token' => $request->token
        ];

        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $destinationPath = 'images/';
            $filename = date('YmdHis') . "." . $file->getClientOriginalExtension();
            $file->move($destinationPath, $filename);
            $path = $destinationPath . $filename;
            $userData['User_photo'] = $path;
        }

        DataUser::where('User_id', $User_id)->update($userData);

        return redirect()->route('user')->with('success', 'Data updated successfully');
    }

    public function destroy($User_id)
    {
        DataUser::where('User_id', $User_id)->delete();
        return redirect()->route('user')->with('success', 'User deleted successfully');
    }
}
