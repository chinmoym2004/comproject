<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Messages;

class Chat extends Model
{
    use HasFactory;

    protected $fillable = ['title','user_id','is_public','group_id'];

    public function user()
    {
        return $this->belongsTo(User::class)->withTimestamps();
    }

    public function members()
    {
        return $this->belongsToMany(User::class,'chat_user')->withPivot('last_active')->withTimestamps();
    }

    public static function search($query)
    {
        // return empty($query) ? static::query()->where('user_type', 'user')
        //     : static::where('user_type', 'user')
        //         ->where(function($q) use ($query) {
        //             $q
        //                 ->where('name', 'LIKE', '%'. $query . '%')
        //                 ->orWhere('email', 'LIKE', '%' . $query . '%')
        //                 ->orWhere('address', 'LIKE ', '%' . $query . '%');
        //         });

        return empty($query) ? static::query() : static::where(function($q) use ($query) {
            $q->where('title', 'LIKE', '%'. $query . '%');
        });
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public function upload()
    {
        return $this->morphMany('App\Models\Upload', 'uploadable');
    }

    public function notifiable()
    {
        return $this->morphMany('App\Models\Inbox', 'notifiable');
    }
}
