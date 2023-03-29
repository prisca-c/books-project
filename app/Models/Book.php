<?php

namespace App\Models;

class Book extends Model
{
    protected array $fillable = [
        'title',
        'authors_id',
        'publishers_id',
    ];
}