<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Onetoonechatuser extends Model
{
    use HasFactory;

    protected $fillable = ['user_id'];

    // protected $with=['user'];

    // public function user()
    // {
    //     return $this->belongsTo(User::class)->withTimestamps();
    // }

    public static function search($query)
    {
        //echo $query;
        return empty($query) ? static::query() : static::where(function($q) use ($query) {
            $q->orWhere('name', 'LIKE', $query . '%');
            $q->orWhere('email', 'LIKE', $query . '%');
           // $q->orWhere('title', 'LIKE', '%'. $query . '%');
        });
    }
}
