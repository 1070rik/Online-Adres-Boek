<?php

namespace AdresBoek;

use Illuminate\Database\Eloquent\Model;

class password_resets extends Model
{
    protected $fillable = [
        'email', 'token'
    ];
}
