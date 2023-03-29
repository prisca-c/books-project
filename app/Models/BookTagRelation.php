<?php

namespace App\Models;

class BookTagRelation extends Model
{
    protected array $fillable = [
        'books_id',
        'tags_id',
    ];
}