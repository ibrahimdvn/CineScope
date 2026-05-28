<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * Toplu atama yapılabilen öznitelikler.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * Serileştirme için gizlenmesi gereken öznitelikler.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Dönüştürülmesi (cast edilmesi) gereken öznitelikler.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function movies()
    {
        return $this->belongsToMany(Movie::class);
    }

    public function posts()          { return $this->hasMany(Post::class); }
    public function likes()          { return $this->hasMany(Like::class); }
    public function comments()       { return $this->hasMany(Comment::class); }
    public function notifications()  { return $this->hasMany(Notification::class); }
    public function activityLogs()   { return $this->hasMany(ActivityLog::class); }
}
