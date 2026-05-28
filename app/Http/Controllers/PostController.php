<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\User;
use App\Models\Notification;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::with('user')
            ->withCount(['likes', 'comments'])
            ->latest()
            ->get();

        // Gündemdekiler: Gönderilerden #hashtag çıkar ve say
        $trendingTags = collect();

        Post::select('content')->get()->each(function ($post) use (&$trendingTags) {
            preg_match_all('/#([\p{L}\p{N}_]+)/u', $post->content, $matches);
            foreach ($matches[1] as $tag) {
                $key = mb_strtolower($tag);
                $trendingTags[$key] = ($trendingTags[$key] ?? 0) + 1;
            }
        });

        $trendingTags = $trendingTags
            ->sortDesc()
            ->take(5)
            ->mapWithKeys(fn($count, $tag) => [$tag => ['tag' => $tag, 'count' => $count]]);

        // Topluluktan: En çok gönderi yapan diğer kullanıcılar
        $suggestedUsers = User::withCount('posts')
            ->when(auth()->check(), fn($q) => $q->where('id', '!=', auth()->id()))
            ->orderByDesc('posts_count')
            ->take(4)
            ->get();

        return view('forum.index', compact('posts', 'trendingTags', 'suggestedUsers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'content' => 'required|string|max:1000',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'rating' => 'nullable|integer|min:1|max:5',
            'tagged_movie_id' => 'nullable|integer',
            'tagged_movie_title' => 'nullable|string|max:255',
            'tagged_movie_type' => 'nullable|string|in:movie,tv',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imageName = time() . '_' . uniqid() . '.' . $request->image->extension();
            $request->image->move(public_path('posts'), $imageName);
            $imagePath = $imageName;
        }

        Post::create([
            'user_id' => auth()->id(),
            'content' => $request->content,
            'image_path' => $imagePath,
            'rating' => $request->rating,
            'tagged_movie_id' => $request->tagged_movie_id,
            'tagged_movie_title' => $request->tagged_movie_title,
            'tagged_movie_type' => $request->tagged_movie_type,
        ]);

        return redirect()->route('forum.index')->with('success', 'Gönderiniz paylaşıldı.');
    }

    public function toggleLike(Post $post)
    {
        $user = auth()->user();
        $existing = $post->likes()->where('user_id', $user->id)->first();

        if ($existing) {
            $existing->delete();
        } else {
            $post->likes()->create(['user_id' => $user->id]);

            if ($post->user_id !== $user->id) {
                Notification::create([
                    'user_id'      => $post->user_id,
                    'from_user_id' => $user->id,
                    'type'         => 'like',
                    'post_id'      => $post->id,
                    'message'      => $user->name . ' gönderini beğendi.',
                ]);
            }
        }

        return back();
    }

    public function storeComment(Request $request, Post $post)
    {
        $request->validate(['content' => 'required|string|max:500']);

        $post->comments()->create([
            'user_id' => auth()->id(),
            'content' => $request->content,
        ]);

        if ($post->user_id !== auth()->id()) {
            Notification::create([
                'user_id'      => $post->user_id,
                'from_user_id' => auth()->id(),
                'type'         => 'comment',
                'post_id'      => $post->id,
                'message'      => auth()->user()->name . ' gönderine yorum yaptı.',
            ]);
        }

        return back();
    }

    public function destroy(Post $post)
    {
        if (auth()->id() != $post->user_id) {
            abort(403);
        }
        
        // Gönderinin görseli varsa diskten sil
        if ($post->image_path) {
            $imagePath = public_path('posts/' . $post->image_path);
            if (file_exists($imagePath)) {
                @unlink($imagePath);
            }
        }

        $post->delete();
        return back()->with('success', 'Gönderi silindi.');
    }
}