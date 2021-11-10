<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'content',
        'title',
        'date',
        'img',
    ];

    
    //record link comment
    public function comments()
        {
        return $this->hasMany(Comment::class);
        }
    //record link like
    public function likes()
        {
        return $this->hasMany (Like::class);
        }
    //record link user        
    public function user()
        {
        return $this->belongsTo(User::class);
        }
}
