<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Badges extends Model
{
    use HasFactory;
    protected $fillable = [
        'name'
    ];

    protected function casts(): array
    {
        return [
            'name' => 'string',
        ];
    }
}
