<?php

namespace App\Models;

class Rating extends Model
{
    protected array $fillable = [
        'users_id',
        'books_id',
        'rating',
        'review'
    ];
}