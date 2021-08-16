<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;                                                                                                             

    protected $fillable = [
      'comment_text',
      'user_id',
      'parent_id'
    ];

    public function commentable(){
        return $this->morphTo();
    }
    
    public function user(){
    	return $this->belongsTo('App\Models\User');
    }

    public function subcomment(){
    	return $this->hasMany('App\Models\Comment','parent_id','id');
    }
}