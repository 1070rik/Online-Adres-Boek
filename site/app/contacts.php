<?php

namespace AdresBoek;

use Illuminate\Database\Eloquent\Model;

class contacts extends Model
{
    protected $fillable = [
        'voornaam', 'tussenvoegsel', 'achternaam', 'geboortedatum', 'telefoonnummer', 'email', 'fotoPad', 'beschrijving', 'adresID', 'toegevoedDoor'
    ];
}
