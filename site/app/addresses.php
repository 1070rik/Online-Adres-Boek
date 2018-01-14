<?php

namespace AdresBoek;

use AdresBoek\contacts;
use Illuminate\Database\Eloquent\Model;

class addresses extends Model
{

    protected $fillable = [
        'straatnaam', 'huisnummer', 'toevoeging', 'postcode', 'plaats', 'longitude', 'latitude',
    ];

    public function contacts()
    {
        return $this->hasMany('AdresBoek\contacts', 'adresID', 'id');
    }
}
