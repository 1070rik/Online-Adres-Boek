<?php

namespace AdresBoek\Http\Controllers;

use Illuminate\Http\Request;
use AdresBoek\contacts;
use AdresBoek\addresses;
use Illuminate\Support\Facades\DB;

class SearchController extends Controller
{
    public function index(){
      echo '
        <form action="' . route("searchPost") . '" method="post">
          <input name="_token" value="' . csrf_token() . '" type="hidden">
          Voornaam: <input type="text" name="voornaam"><br>
          tussenvoegsel: <input type="text" name="tussenvoegsel"><br>
          Achternaam: <input type="text" name="achternaam"><br>
          Straatnaam: <input type="text" name="straatnaam"><br>
          Huisnummer: <input type="text" name="huisnummer"><br>
          Plaats: <input type="text" name="plaats"><br>
          Postcode: <input type="text" name="postcode"><br>
          <input type="submit">
        </form>
      ';
    }

    public function postIndex(Request $request)
    {
      $input = $request->all();
      unset($input['_token']);
      $addresses = DB::table('addresses')
            ->join('contacts', 'addresses.id', '=', 'contacts.adresID')
            ->where('contacts.voornaam', 'like', '%' . $request->voornaam . '%')
            ->where('contacts.tussenvoegsel', 'like', '%' . $request->tussenvoegsel . '%')
            ->where('contacts.achternaam', 'like', '%' . $request->achternaam . '%')
            ->where('addresses.straatnaam', 'like', '%' . $request->straatnaam . '%')
            ->where('addresses.huisnummer', 'like', '%' . $request->huisnummer . '%')
            ->where('addresses.plaats', 'like', '%' . $request->plaats . '%')
            ->where('addresses.postcode', 'like', '%' . $request->postcode . '%')
            ->get();

      // foreach ($addresses as $address) {
      //   echo $address->voornaam . ", " . $address->tussenvoegsel . " " . $address->achternaam;
      // }
      return view('searchResults', compact('addresses'));
    }
}
