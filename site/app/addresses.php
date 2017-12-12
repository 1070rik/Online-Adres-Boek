<?php

namespace AdresBoek;

use Illuminate\Database\Eloquent\Model;
use AdresBoek\contacts;

class addresses extends Model
{

    protected $fillable = [
        'straatnaam', 'huisnummer', 'toevoeging', 'postcode', 'plaats', 'longitude', 'latitude'
    ];


    public function contacts() {
      return $this->hasMany('AdresBoek\contacts', 'adresID', 'id');
    }
}
