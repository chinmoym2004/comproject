<?php
namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function scopeImage()
    {
        $path = asset('img/user-placeholder.png');
        return $path;
    }

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
