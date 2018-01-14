<?php

namespace AdresBoek\Http\Controllers;

use Illuminate\Http\Request;
use AdresBoek\contacts;
use AdresBoek\addresses;
use Illuminate\Support\Facades\DB;

class SearchController extends Controller
{
    public function index(){
      //Serve home view
      return view('search.search');
    }

    public function postIndex(Request $request)
    {
      //Put all post data in input
      $input = $request->all();

      if(!$request->sort){
        //If no sort parmeter is available then just sort on firstname
        $sort = 'contacts.voornaam';
      }else{
        //Else just set sorting method on sort method in parameter
        $sort = $request->sort;
      }

      //Remove CSRF token field 
      unset($input['_token']);
      //Create new query with filter from website
      $query = DB::table('addresses')
			->select('*', 'contacts.id as contID')
            //Join contacts and addresses together
            ->join('contacts', 'addresses.id', '=', 'contacts.adresID')
            ->where('contacts.voornaam', 'like', '%' . $request->voornaam . '%')
            //->where('contacts.tussenvoegsel', 'like', '%' . $request->tussenvoegsel . '%') tussenvoegsel can be null
            ->where('contacts.achternaam', 'like', '%' . $request->achternaam . '%')
            ->where('addresses.straatnaam', 'like', '%' . $request->straatnaam . '%')
            ->where('addresses.huisnummer', 'like', '%' . $request->huisnummer . '%')
            ->where('addresses.plaats', 'like', '%' . $request->plaats . '%')
            ->where('addresses.postcode', 'like', '%' . $request->postcode . '%')
		        ->groupBy('contacts.id')
            //Order by the supplied sorting method and filter
            ->orderByRaw($sort . ' ' . $request->filter)
            ->get();

      //If the request was made via the API then return in it JSON format
      if($request->api == 1){
    		$contacts = array();
    		$addresses = array();

        //Put all usefull information from the contacts in a new array
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


          //Put all usefull information from the addresses in a new array
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

            //Join the 2 arrays together
            $jsonArray = array("contacts" => $contacts, "addresses" => $addresses, "input" => $input);
            $jsonCombined = json_encode($jsonArray);
            return $jsonCombined;
        }else{
            return view('search.searchResults', compact('query'));
        }
    }
}
