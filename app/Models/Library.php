<?php

namespace App\Models;

use Core\Model;

class Library extends Model
{
    protected array $fillable = [
        'note',
        'editions_id',
        'users_id',
        'status_id'
    ];
}