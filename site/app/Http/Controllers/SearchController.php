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

      if(!$request->sort){
        $sort = 'contacts.voornaam';
      }else{
        $sort = $request->sort;
      }

      unset($input['_token']);
      $query = DB::table('addresses')
			->select('*', 'contacts.id as contID')
            ->join('contacts', 'addresses.id', '=', 'contacts.adresID')
            ->where('contacts.voornaam', 'like', '%' . $request->voornaam . '%')
            //->where('contacts.tussenvoegsel', 'like', '%' . $request->tussenvoegsel . '%') tussenvoegsel can be null
            ->where('contacts.achternaam', 'like', '%' . $request->achternaam . '%')
            ->where('addresses.straatnaam', 'like', '%' . $request->straatnaam . '%')
            ->where('addresses.huisnummer', 'like', '%' . $request->huisnummer . '%')
            ->where('addresses.plaats', 'like', '%' . $request->plaats . '%')
            ->where('addresses.postcode', 'like', '%' . $request->postcode . '%')
		    ->groupBy('contacts.id')
            ->orderByRaw($sort . ' ' . $request->filter)
            ->get();

      if($request->api == 1){
    		$contacts = array();
    		$addresses = array();

    		foreach ($query as $row){
    			$contactRow = array("id" => $row->contID,
    				"voornaam" => $row->voornaam,
    				"tussenvoegsel" => $row->tussenvoegsel,
    				"achternaam" => $row->achternaam,
    				"telefoonnummer" => $row->telefoonnummer,
                    "fotoPad" => $row->fotoPad,
    				"email" => $row->email,
    				"beschrijving" => $row->beschrijving,
    				"adresID" => $row->adresID);
    			 array_push($contacts, $contactRow);


    			if(!in_array($row->adresID, array_column($addresses, "id"), true)){
    				$addressRow = array("id" => $row->adresID,
    					"straatnaam" => $row->straatnaam,
    					"huisnummer" => $row->huisnummer,
    					"toevoeging" => $row->toevoeging,
    					"postcode" => $row->postcode,
    					"plaats" => $row->plaats,
    					"longitude" => $row->longitude,
    					"latitude" =>$row->latitude);
    				array_push($addresses, $addressRow);
    			}
    		}

          $jsonArray = array("contacts" => $contacts, "addresses" => $addresses, "input" => $input);
          $jsonCombined = json_encode($jsonArray);
          return $jsonCombined;
        }else{
          return view('search.searchResults', compact('query'));
      }
    }
}
