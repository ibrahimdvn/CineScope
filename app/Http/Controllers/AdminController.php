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
        $users = \App\Models\User::orderBy('id', 'desc')->paginate(20);
        return view('admin.users', compact('users'));
    }

    public function deleteUser($id)
    {
        $user = \App\Models\User::findOrFail($id);
        
        // Admin hesabını silmeyi engelle
        if ($user->role === 'admin' || $user->id === 1) {
            return back()->with('error', 'Ana yönetici hesabı silinemez!');
        }
        
        $user->delete();
        return back()->with('success', 'Kullanıcı başarıyla silindi.');
    }

    public function settings()
    {
        return view('admin.settings');
    }

    public function updateSettings(Request $request)
    {
        // Sadece demo amaçlı simüle ediliyor
        return back()->with('success', 'Sistem ayarları başarıyla güncellendi!');
    }
}
