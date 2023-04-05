<?php

namespace App\Models;

use Core\Model;

class Wishlist extends Model
{
    protected array $fillable = [
        'users_id',
        'editions_id'
    ];
}