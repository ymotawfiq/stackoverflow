<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserBadges extends Model
{
    use HasFactory;


    protected $fillable = [
        'user_id',
        'badge_id'
    ];

    public function user(){
        return $this->hasMany(User::class);
    }

    public function badge(){
        return $this->hasMany(Badges::class);
    }

}
