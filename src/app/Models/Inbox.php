<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inbox extends Model
{
    use HasFactory;

    protected $fillable = [
        'show_text',
        'action_by',
        'user_id',
        'redirect_url'
    ];

    public static function search($query)
    {
        return empty($query) ? static::query() : static::where(function($q) use ($query) {
            $q->where('show_text', 'LIKE', '%'. $query . '%');
        });
    }

    public function notifiable(){
        return $this->morphTo();
    }

    public function fromuser(){
        return $this->belongsTo(\App\Models\User::class,'action_by','id');
    }
}
