<?php

namespace AdresBoek;

use Illuminate\Database\Eloquent\Model;

class addresses extends Model
{
    protected $fillable = [
        'straatnaam', 'huisnummer', 'toevoeging', 'postcode', 'plaats', 'longitude', 'altitude'
    ];
}
