<?php

namespace App\Models;

use Core\Model;

class User extends Model
{
    protected array $fillable = [
        'username',
        'password',
        'email',
    ];
}