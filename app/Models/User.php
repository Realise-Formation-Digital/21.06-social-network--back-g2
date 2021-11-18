<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'avatar',
        'pseudo',
        'password',
        'email',
        'email_verified_at',
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
    
    //record link post
    public function posts()
        {
        return $this->hasMany(Post::class);
        }
    //record link like
    public function likes()
        {
        return $this->hasMany (Like::class);
        }
    //record link comment        
    public function comments()
        {
        return $this->hasMany(Comment::class);
        }
    //record link abbonements
    public function abbonements()
        {
        return $this->hasOne(Abbonement::class);
        }
}