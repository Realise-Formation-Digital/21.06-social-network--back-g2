<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Abbonement extends Model
{
    use HasFactory;
    protected $fillable = ['prix','date_deb','date_fin'];

    //record link user
    public function user()
    {
        return $this->belongTo(User::class);
    }

}
