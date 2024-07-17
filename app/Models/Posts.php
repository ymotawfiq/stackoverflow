<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Posts extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'body',
        'post_type_id'
    ];

    protected $hidden = [
        'answers',
        'comments',
        'tags',
        'views'
    ];
}
