<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Topic;

class Forum extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'post_count',
        'topic_count',
        'user_id'
    ];

    public static function search($query)
    {
        return empty($query) ? static::query() : static::where(function($q) use ($query) {
            $q->where('name', 'LIKE', '%'. $query . '%');
        });
    }

    public function topics()
    {
        return $this->hasMany(Topic::class);
    }
}
