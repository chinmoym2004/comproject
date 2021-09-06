<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Forum;

class Topic extends Model
{
    use HasFactory;

    protected $fillable=[
        'title',
        'body',
        'user_id',
        'status',
        'slug'
    ];

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    public static function search($query)
    {
        return empty($query) ? static::query() : static::where(function($q) use ($query) {
            $q->where('title', 'LIKE', '%'. $query . '%');
        });
    }

    public function comments()
    {
        return $this->morphMany('App\Models\Comment', 'commentable')->orderBy('created_at','DESC');
    }

    public function forum()
    {
        return $this->belongsTo(Forum::class);
    }

    public function action()
    {
        return $this->hasMany(\App\Models\TopicAction::class);
    }

    public function scopeUseractions($q,$user_id)
    {
        return $this->hasMany(\App\Models\TopicAction::class)->where('user_id',$user_id);
    }
    

    public function scopeUpvote($q,$action_type=1)
    {
        return $this->action()->where('action_type',$action_type);
    }

    public function scopeUservoted($q)
    {
        $user_id = \Auth::user()->id;
        return $this->useractions($user_id)->where('action_type','=',1)->count();
    }
}
