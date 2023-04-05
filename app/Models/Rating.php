<?php

namespace App\Models;

use Core\Model;

class Rating extends Model
{
    protected array $fillable = [
        'users_id',
        'books_id',
        'rating',
        'review'
    ];
}