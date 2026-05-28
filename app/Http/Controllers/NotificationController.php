<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notification;

class NotificationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $notifications = auth()->user()
            ->notifications()
            ->with('fromUser', 'post')
            ->latest()
            ->paginate(20);

        // Okunmamış olanları oku
        auth()->user()->notifications()
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        return view('forum.notifications', compact('notifications'));
    }

    public function unreadCount()
    {
        $count = auth()->user()->notifications()->whereNull('read_at')->count();
        return response()->json(['count' => $count]);
    }
}
