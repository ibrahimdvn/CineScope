<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function login()
    {
        return view('admin.login');
    }

    public function authenticate(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        if ($request->username === 'admin' && $request->password === '123456') {
            session(['admin_logged_in' => true]);
            return redirect()->route('admin.dashboard');
        }

        return back()->withErrors(['error' => 'Kullanıcı adı veya şifre hatalı.']);
    }

    public function logout()
    {
        session()->forget('admin_logged_in');
        return redirect()->route('admin.login');
    }

    public function dashboard()
    {
        return view('admin.dashboard');
    }

    public function users()
    {
        // $users = \App\Models\User::paginate(20);
        return view('admin.users');
    }

    public function movies()
    {
        // Film verilerini veritabanından veya API'den alabilirsiniz
        return view('admin.movies');
    }

    public function settings()
    {
        return view('admin.settings');
    }
}
