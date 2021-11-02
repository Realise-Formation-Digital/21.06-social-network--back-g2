<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'Content',
        'Title',
        'Date',
        'Img',
    ];

    
    //record link comment
    public function comment()
        {
        return $this->hasMany(Comment::class);
        }
    //record link like
    public function like()
        {
        return $this->hasMany (Like::class);
        }
    //record link user        
    public function user()
        {
        return $this->belongTo(User::class);
        }
}
