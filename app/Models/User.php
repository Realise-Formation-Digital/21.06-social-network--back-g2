<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'FirsName',
        'LastName',
        'Avatar',
        'Pseudo',
        'Password',
        'Email',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'Password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'Email_verified_at' => 'datetime',
    ];
    
    //record link post
    public function post()
        {
        return $this->hasMany(Post::class);
        }
    //record link like
    public function like()
        {
        return $this->hasOne (Like::class);
        }
    //record link comment        
    public function comment()
        {
        return $this->hasOne(Comment::class);
        }
}