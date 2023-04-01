<?php

namespace App\Models;

class Edition extends Model
{
    protected array $fillable = [
        'format',
        'description',
        'image',
        'books_id',
        'published_at'
    ];
}