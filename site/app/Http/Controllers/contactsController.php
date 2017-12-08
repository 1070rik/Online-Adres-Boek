<?php

namespace AdresBoek\Http\Controllers;

use Illuminate\Http\Request;
use AdresBoek\contacts;
use AdresBoek\addresses;

class contactsController extends Controller
{
  public function index() {
    return view('addContactForm');
  }

  public function addContact(Request $request) {
    $adres = addresses::create([
      'straatnaam' => $request['straatnaam'],
      'huisnummer' => $request['huisnummer'],
      'toevoeging' => $request['toevoeging'],
      'postcode'   => $request['postcode'],
      'plaats'     => $request['plaats'],
      'longitude'  => $request['longtitude'],
      'latitude'   => $request['latitude']
    ]);

    $contact = contacts::create([
      'voornaam'       => $request['voornaam'],
      'tussenvoegsel'  => $request['tussenvoegsel'],
      'achternaam'     => $request['achternaam'],
      'geboortedatum'  => $request['geboortedatum'],
      'telefoonnummer' => $request['telefoonnummer'],
      'email'          => $request['email'],
      'fotoPad'        => $request['fotoPad'],
      'adresID'        => $adres['id'],
      'beschrijving'   => $request['beschrijving']
    ]);

    return "User with name " + $contact['voornaam'] + $contact['achternaam'] + " toegevoegd door " + $contact['toegevoegdDoor'];
  }
}
