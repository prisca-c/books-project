<?php

namespace App\Models;

use Core\Model;

class BookTagRelation extends Model
{
    protected array $fillable = [
        'books_id',
        'tags_id',
    ];
}