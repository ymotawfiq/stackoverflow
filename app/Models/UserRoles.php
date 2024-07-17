<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class UserRoles extends Model
{
    use HasFactory, HasUuids, Notifiable;
    protected $fillable = [
        'user_id',
        'role_id'
    ];
}
