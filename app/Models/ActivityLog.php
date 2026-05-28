<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    protected $fillable = [
        'user_id',
        'activity_type',
        'description',
        'ip_address',
        'user_agent'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Aktivite kaydı oluşturur (Türkçe açıklamalar ile).
     */
    public static function log($type, $description, $userId = null)
    {
        return self::create([
            'user_id' => $userId ?? auth()->id(),
            'activity_type' => $type,
            'description' => $description,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
    }
}
