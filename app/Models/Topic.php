<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
    use HasFactory;

    protected $fillable=[
        'title',
        'body',
        'user_id',
        'status'
    ];

    public static function search($query)
    {
        return empty($query) ? static::query() : static::where(function($q) use ($query) {
            $q->where('title', 'LIKE', '%'. $query . '%');
        });
    }

    public function comments()
    {
        return $this->morphMany('App\Models\Comment', 'commentable');
    }
}
