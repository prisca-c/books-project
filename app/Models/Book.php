<?php

namespace App\Models;

use Core\Model;

class Book extends Model
{
    protected array $fillable = [
        'title',
        'authors_id',
        'publishers_id',
        'published_at',
        'synopsis'
    ];
}