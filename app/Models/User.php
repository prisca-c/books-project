<?php

namespace App\Models;

class User extends Model
{
    protected array $fillable = [
        'username',
        'password',
        'email',
    ];
}