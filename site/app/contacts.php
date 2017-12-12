<?php

namespace AdresBoek;

use Illuminate\Database\Eloquent\Model;
use AdresBoek\addresses;

class contacts extends Model
{

    protected $fillable = [
        'voornaam', 'tussenvoegsel', 'achternaam', 'geboortedatum', 'telefoonnummer', 'email', 'fotoPad', 'beschrijving', 'adresID', 'toegevoedDoor'
    ];


    public function addresses(){
        return $this->belongsTo('AdresBoek\addresses', 'adresID', 'id');
    }

}
