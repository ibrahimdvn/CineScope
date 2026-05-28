<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'from_user_id', 'type', 'post_id', 'message', 'read_at'];

    protected $casts = [
        'read_at' => 'datetime',
    ];

    public function user()       { return $this->belongsTo(User::class); }
    public function fromUser()   { return $this->belongsTo(User::class, 'from_user_id'); }
    public function post()       { return $this->belongsTo(Post::class); }

    public function isRead(): bool
    {
        return !is_null($this->read_at);
    }
}
