<?php

namespace AdresBoek\Http\Controllers;

use Illuminate\Http\Request;
use AdresBoek\contacts;
use AdresBoek\addresses;
use Illuminate\Support\Facades\DB;

include_once(app_path() . '/coordsHandler.php');
use AdresBoek\CoordsHandler;

class contactsController extends Controller
{
  public function index() {
    return view('contacts.addContactForm');
  }

  public function addContact(Request $request) {

    $contact = contacts::where('email', $request['email'])->get();

    if (count($contact) > 0){
      print_r($contact);
      return redirect('editContact')->with([
        'error' => 'Contact with given email exists already!'
      ]);
    } else {

      $addresses = addresses::
          where('straatnaam', $request['straatnaam'])
        ->where('huisnummer', $request['huisnummer'])
        ->where('toevoeging', $request['toevoeging'])
        ->where('postcode', $request['postcode'])
        ->where('plaats', $request['plaats'])
        ->where('longitude', $request['longtitude'])
        ->where('latitude', $request['latitude'])
        ->get();

      $addressID = 0;

      if (count($addresses) > 0){
        $addressID = $addresses[0]['id'];
      } else {

        $coords = CoordsHandler::getGeoCoords(
          $request['straatnaam'] . ' ' . 
          $request['huisnummer'] . ' ' . 
          $request['toevoeging'] . '+' . 
          $request['postcode'] . '+' . 
          $request['plaats']);

        $longitude = $coords['lng'];
        $latitude = $coords['lat'];

        $address = addresses::create([
          'straatnaam' => $request['straatnaam'],
          'huisnummer' => $request['huisnummer'],
          'toevoeging' => $request['toevoeging'],
          'postcode'   => $request['postcode'],
          'plaats'     => $request['plaats'],
          'longitude'  => $longitude,
          'latitude'   => $latitude
        ]);

        $addressID = $address['id'];
      }

      $contact = contacts::create([
        'voornaam'       => $request['voornaam'],
        'tussenvoegsel'  => $request['tussenvoegsel'],
        'achternaam'     => $request['achternaam'],
        'geboortedatum'  => $request['geboortedatum'],
        'telefoonnummer' => $request['telefoonnummer'],
        'email'          => $request['email'],
        'fotoPad'        => $request['fotoPad'],
        'adresID'        => $addressID,
        'beschrijving'   => $request['beschrijving']
      ]);

      return redirect('editContact');
    }    
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
