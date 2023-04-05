<?php

namespace App\Models;

use Core\Model;

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