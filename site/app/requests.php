<?php

namespace AdresBoek;

use Illuminate\Database\Eloquent\Model;

class requests extends Model
{
    protected $fillable = [
        'email', 'password', 'admin'
    ];
}
