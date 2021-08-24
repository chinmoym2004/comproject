<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Group extends Model
{
    use HasFactory;

    protected $fillable=[
        'title',
        'description',
        'created_by'
    ];

    public static function search($query)
    {
        return empty($query) ? static::query() : static::where(function($q) use ($query) {
            $q->orWhere('title', 'LIKE', '%'. $query . '%');
        });
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class,'created_by','id');
    }

    public function members()
    {
        return $this->belongsToMany(User::class,'group_user');
    }
}
