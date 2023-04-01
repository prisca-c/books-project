<?php

namespace App\Models;

class Library extends Model
{
    protected array $fillable = [
        'note',
        'editions_id',
        'users_id',
        'status_id'
    ];
}