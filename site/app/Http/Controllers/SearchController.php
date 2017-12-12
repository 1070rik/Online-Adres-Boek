<?php

namespace AdresBoek\Http\Controllers;

use Illuminate\Http\Request;
use AdresBoek\contacts;
use AdresBoek\addresses;

class SearchController extends Controller
{
    public function index(){
      // $adresses = addresses::where([
      //        'straatnaam' => 'h'
      // ])->get();
      //
      // foreach($adresses as $adres){
      //   echo '-------------- <br>';
      //
      //   echo "voornaam: " . $adres->contacts[0]->voornaam . "<br>";
      //   echo "tussenvoegsel: " . $adres->contacts[0]->tussenvoegsel . "<br>";
      //   echo "achternaam: " . $adres->contacts[0]->achternaam . "<br>";
      //   echo "straatnaam: " . $adres->straatnaam . "<br>";
      //   echo "postcode: " . $adres->postcode . "<br>";
      //
      //   echo '-------------- <br><br>';
      // }

      echo '
        <form action="' . route("searchPost") . '" method="post">
          <input name="_token" value="' . csrf_token() . '" type="hidden">
          <input type="text" name="straatnaam">
          <input type="text" name="postcode">
          <input type="text" name="plaats">
          <input type="text" name="voornaam">
          <input type="submit">
        </form>
      ';

    }

    public function postIndex(Request $request)
    {
      $input = $request->all();
      unset($input['_token']);
      $contacts = contacts::get();
      $adresses = addresses::where('straatnaam', 'like', $request->straatnaam . '%')
      ->where('postcode', 'like', $request->postcode . '%')
      ->where('plaats', 'like', $request->plaats . '%')
      ->where('voornaam', 'like', )
      ->get();

      foreach($adresses as $adres){
        echo '-------------- <br>';

        echo "voornaam: " . $adres->contacts[0]->voornaam . "<br>";
        echo "tussenvoegsel: " . $adres->contacts[0]->tussenvoegsel . "<br>";
        echo "achternaam: " . $adres->contacts[0]->achternaam . "<br>";
        echo "straatnaam: " . $adres->straatnaam . "<br>";
        echo "postcode: " . $adres->postcode . "<br>";

      }
    }
}
