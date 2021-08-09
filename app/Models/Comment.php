<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
		'comment_text',
		'comment_by',
		'parent_id'
    ];

    public function commentable(){
        return $this->morphTo();
    }
}