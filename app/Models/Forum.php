<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Topic;
use App\Models\Group;

class Forum extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'post_count',
        'topic_count',
        'user_id',
        'campus',
        'school',
        'program',
        'details',
        'category_id',
        'group_id',
        'is_public',
        'slug'
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

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function group()
    {
        return $this->belongsTo(Group::class);
    }
}
