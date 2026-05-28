<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except('show');
    }

    public function show($id)
    {
        $user = \App\Models\User::with('movies')->findOrFail($id);
        $favoriteMovies = $user->movies()->paginate(20);
        return view('profile.show', compact('user', 'favoriteMovies'));
    }

    public function index()
    {
        $user = Auth::user();
        return view('profile.index', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'bio' => 'nullable|string|max:1000',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->bio = $request->bio;

        if ($request->hasFile('avatar')) {
            $avatarName = time() . '.' . $request->avatar->extension();  
            $request->avatar->move(public_path('avatars'), $avatarName);
            $user->avatar = $avatarName;
        }

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('profile.index')->with('success', 'Profil bilgileriniz başarıyla güncellendi.');
    }

    public function destroy(Request $request)
    {
        $request->validate([
            'password' => 'required',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->password, $user->password)) {
            return back()->withErrors(['delete_confirm' => 'Girilen şifre yanlış.'])->with('error', 'Şifre hatalı olduğu için hesabınız silinemedi.');
        }

        // Profil resmini sil
        if ($user->avatar) {
            $avatarPath = public_path('avatars/' . $user->avatar);
            if (file_exists($avatarPath)) {
                @unlink($avatarPath);
            }
        }

        // Gönderi görsellerini sil ve gönderileri kaldır
        foreach ($user->posts as $post) {
            if ($post->image_path) {
                $postImagePath = public_path('posts/' . $post->image_path);
                if (file_exists($postImagePath)) {
                    @unlink($postImagePath);
                }
            }
            $post->delete();
        }

        // İlişkileri temizle
        $user->movies()->detach();
        $user->comments()->delete();
        $user->likes()->delete();
        $user->notifications()->delete();

        // Kullanıcıyı sil
        $user->delete();

        // Oturumu kapat
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('movies.index')->with('success', 'Hesabınız ve tüm verileriniz kalıcı olarak silindi.');
    }
}
