<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FollowPost extends Model
{
    use HasFactory;
    protected $fillable = [
        'post_id'
    ];

    protected $hidden = [
        'user_id'
    ];

    public function users(){
        return $this->hasMany(User::class);
    }

    public function posts(){
        return $this->hasMany(Posts::class);
    }
}
