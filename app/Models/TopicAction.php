<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TopicAction extends Model
{
    use HasFactory;

    //1=>upvote,2=>accepted,3=>spam

    public function setActionTypeAttribute($value)
    {
        $this->attributes['action_type'] = ($value=='upvote'?1:($value=='spam'?3:0));
    }

    protected $fillable=[
        'user_id',
        'action_type'
    ];
}
