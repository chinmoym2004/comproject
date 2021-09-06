<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $table="category";

    protected $fillable=[
        'name',
        'details',
        'created_by'
    ];

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class,'created_by','id');
    }

    public static function search($query)
    {
        //echo $query;
        return empty($query) ? static::query() : static::where(function($q) use ($query) {
           $q->orWhere('name', 'LIKE', '%'. $query . '%');
        });
    }
}
