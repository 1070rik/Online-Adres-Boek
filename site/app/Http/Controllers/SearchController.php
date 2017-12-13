<?php

namespace AdresBoek\Http\Controllers;

use Illuminate\Http\Request;
use AdresBoek\contacts;
use AdresBoek\addresses;
use Illuminate\Support\Facades\DB;

class SearchController extends Controller
{
    public function index(){
      return view('search.search');
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
      if($request->api == 1){
        $addressArray = array("contacts" => $addresses);
        $addresses = json_encode($addressArray);
        return $addresses;
      }else{
        return view('search.searchResults', compact('addresses'));
      }
    }
}
