<?php

namespace AdresBoek;

use AdresBoek\addresses;
use Illuminate\Database\Eloquent\Model;

class contacts extends Model
{

    protected $fillable = [
        'voornaam', 'tussenvoegsel', 'achternaam', 'geboortedatum', 'telefoonnummer', 'email', 'fotoPad', 'beschrijving', 'adresID', 'toegevoedDoor',
    ];

    public function addresses()
    {
        return $this->belongsTo('AdresBoek\addresses', 'adresID', 'id');
    }

}
