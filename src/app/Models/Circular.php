<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Circular extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'details',
        'need_confirmation',
        'user_id',
        'published',
        'group_ids'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function members()
    {
        return $this->belongsToMany(User::class,'circular_user')->withPivot('has_confirmed')->withTimestamps();
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

    public function scopeMyack($query)
    {
        $me = \Auth::user()->id;
        return $this->members()->where('user_id','=',$me)->where('has_confirmed','=',1)->first() ?? false;
    }
}
