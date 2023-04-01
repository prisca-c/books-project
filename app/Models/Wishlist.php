<?php

namespace App\Models;

class Wishlist extends Model
{
    protected array $fillable = [
        'users_id',
        'editions_id'
    ];
}