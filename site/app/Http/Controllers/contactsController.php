<?php

namespace AdresBoek\Http\Controllers;

use Illuminate\Http\Request;
use AdresBoek\contacts;
use AdresBoek\addresses;
use Illuminate\Support\Facades\DB;

class contactsController extends Controller
{
  public function index() {
    return view('contacts.addContactForm');
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

    return redirect('editContact');
  }

  public function editContact(Request $request){
      $contacts = contacts::get();
      return view('contacts.getAllContacts', compact('contacts'));
  }

  public function editContactPost(Request $request){
      if($request['edit']){
          contacts::where('id', $request['id'])->update([ 'voornaam'        => $request['voornaam'],
                                                          'tussenvoegsel'   => $request['tussenvoegsel'],
                                                          'achternaam'      => $request['achternaam'],
                                                          'geboortedatum'   => $request['geboortedatum'],
                                                          'telefoonnummer'  => $request['telefoonnummer'],
                                                          'email'           => $request['email'],
                                                          'fotoPad'         => $request['fotoPad'],
                                                          'beschrijving'    => $request['beschrijving']]);
      }else{
          contacts::where('id', $request['id'])->delete();
      }
    return redirect('editContact');
  }

  public function getAllContactsAjax(Request $request){
      $contacts = contacts::get();
      $addresses = addresses::get();

      $jsonArray = array("contacts" => $contacts, "addresses" => $addresses);

      $jsonCombined = json_encode($jsonArray);

      echo $jsonCombined;
  }

  public function viewContact(Request $request, $id){
    $contact = DB::table('contacts')
          ->join('addresses', 'contacts.adresID', '=', 'addresses.id')
          ->where('contacts.id', $id)
          ->first();

    return view('contacts.viewContact', compact('contact'));
  }
}
