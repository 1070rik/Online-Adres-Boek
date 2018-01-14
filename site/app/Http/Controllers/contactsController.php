<?php

namespace AdresBoek\Http\Controllers;

use AdresBoek\addresses;
use AdresBoek\contacts;
use AdresBoek\CoordsHandler;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

include_once app_path() . '/coordsHandler.php';
use Illuminate\Support\Facades\Storage;

class contactsController extends Controller
{
    public function index()
    {
        return view('contacts.addContactForm');
    }

    public function addContact(Request $request)
    {

        $contact = contacts::where('email', $request['email'])->get();

        if (count($contact) > 0) {
            return redirect('adminGetAllContacts')->with([
                'error' => 'Contact with given email exists already!',
            ]);
        } else {
            $image = $request->file('fotoPad')->getClientOriginalName();

            $filename = $image;
            if ($request->hasFile('fotoPad')) {
                if (file_exists($filename)) {
                    echo 'uploaded <br/>';
                    echo '<img src="contactImages/' . $filename . '"/>';
                } else {
                    echo 'uploaded <br/>';
                    $file = $request->file('fotoPad');
                    $file->move('imgs/contactImages', $filename);
                }
            }

            $contact = contacts::create([
                'voornaam'       => $request['voornaam'],
                'tussenvoegsel'  => $request['tussenvoegsel'],
                'achternaam'     => $request['achternaam'],
                'geboortedatum'  => $request['geboortedatum'],
                'telefoonnummer' => $request['telefoonnummer'],
                'email'          => $request['email'],
                'fotoPad'        => $filename,
                'adresID'        => $this->getOrCreateAddress($request),
                'beschrijving'   => $request['beschrijving'],
            ]);

            return redirect('admin/contacts');
        }
    }

    public function getAddressID(Request $request, $excludeID)
    {
        $addresses = addresses::
            where('straatnaam', $request['straatnaam'])
            ->where('huisnummer', $request['huisnummer'])
            ->where('toevoeging', $request['toevoeging'])
            ->where('postcode', $request['postcode'])
            ->where('plaats', $request['plaats'])
            ->get();

        if (count($addresses) > 0) {
            foreach ($addresses as $address) {
                if ($address['id'] != $excludeID) {
                    return $address['id'];
                }
            }
        }

        return 0;
    }

    public function addAddress(Request $request)
    {
        $coords = CoordsHandler::getGeoCoords(
            $request['straatnaam'] . ' ' .
            $request['huisnummer'] . ' ' .
            $request['toevoeging'] . '+' .
            $request['postcode'] . '+' .
            $request['plaats']);

        $longitude = $coords['lng'];
        $latitude  = $coords['lat'];

        $address = addresses::create([
            'straatnaam' => $request['straatnaam'],
            'huisnummer' => $request['huisnummer'],
            'toevoeging' => $request['toevoeging'],
            'postcode'   => $request['postcode'],
            'plaats'     => $request['plaats'],
            'longitude'  => $longitude,
            'latitude'   => $latitude,
        ]);

        return $address;
    }

    public function getOrCreateAddress(Request $request)
    {
        $addressID = $this->getAddressID($request, 0);

        if ($addressID > 0) {
            return $addressID;
        } else {
            return contactsController::addAddress($request)['id'];
        }
    }

    public function removeContacts(Request $request)
    {
        $contactIDs = json_decode($request['toDeleteElements']);

        foreach ($contactIDs as $contactID) {
            $contact  = contacts::where('id', $contactID)->get()[0];
            $contacts = contacts::where('adresID', $contact['adresID'])->get();

            contacts::where('id', $contactID)->delete();

            if (count($contacts) == 1) {
                contactsController::removeAddressById($contact['adresID']);
            }
        }

        return redirect('admin/contacts');
    }

    public function editAddress(Request $request)
    {

        $coords = CoordsHandler::getGeoCoords(
            $request['straatnaam'] . ' ' .
            $request['huisnummer'] . ' ' .
            $request['toevoeging'] . '+' .
            $request['postcode'] . '+' .
            $request['plaats']);

        echo "addresID: " . $request['id'];

        addresses::where('id', $request['id'])->update(['straatnaam' => $request['straatnaam'],
            'huisnummer'                                                 => $request['huisnummer'],
            'toevoeging'                                                 => $request['toevoeging'],
            'postcode'                                                   => $request['postcode'],
            'plaats'                                                     => $request['plaats'],
            'longitude'                                                  => $coords['lng'],
            'latitude'                                                   => $coords['lat'],
        ]);
    }

    public function removeAddressById($id)
    {
        addresses::where('id', $id)->delete();
    }

    public function editContact(Request $request)
    {
        $contacts = contacts::get();
        return view('contacts.getAllContacts', compact('contacts'));
    }

    public function editContactPost(Request $request)
    {
        $contacts = contacts::where('id', $request['id'])->get();

        // Check if contact already exists. If found, return. If not, continue.
        if (count($contacts) > 0) {
            $found = false;

            foreach ($contacts as $contact) {
                if ($contact->id == $request['id']) {
                    $found = true;
                    break;
                }
            }

            if (!$found) {
                return redirect('admin/contacts')->with([
                    'error' => 'Contact with given email exists already!',
                ]);
            }
        }

        contacts::where('id', $request['id'])->update(['voornaam' => $request['voornaam'],
            'tussenvoegsel'                                           => $request['tussenvoegsel'],
            'achternaam'                                              => $request['achternaam'],
            'geboortedatum'                                           => $request['geboortedatum'],
            'telefoonnummer'                                          => $request['telefoonnummer'],
            'email'                                                   => $request['email'],
            'fotoPad'                                                 => $request['fotoPad'],
            'beschrijving'                                            => $request['beschrijving']]);

        $contact  = contacts::where('id', $request['id'])->get()[0];
        $contacts = contacts::where('adresID', $contact['adresID'])->get();

        if (count($contacts) > 1) {
            // More contacts have the same addressID
            $addressID = contactsController::getOrCreateAddress($request);
            contacts::where('id', $request['id'])->update(['adresID' => $addressID]);

        } else {
            // Current contact is the only contact with this addressID
            $addressID = $this->getAddressID($request, $contact['adresID']);

            if ($addressID > 0) {
                // changed address already exists
                contacts::where('id', $request['id'])->update(['adresID' => $addressID]);
                contactsController::removeAddressById($contact['adresID']);
            } else {
                // changed address doesn't exist yet

                $newAddress = contactsController::addAddress($request);
                contacts::where('id', $request['id'])->update(['adresID' => $newAddress['id']]);
            }
        }

        return redirect('admin/contacts');
    }

    public function getAllContactsAjax(Request $request)
    {
        $contacts  = contacts::get();
        $addresses = addresses::get();

        $jsonArray = array("contacts" => $contacts, "addresses" => $addresses);

        $jsonCombined = json_encode($jsonArray);

        echo $jsonCombined;
    }

    public function viewContact(Request $request, $id)
    {
        $contact = DB::table('contacts')
            ->join('addresses', 'contacts.adresID', '=', 'addresses.id')
            ->where('contacts.id', $id)
            ->first();

        return view('contacts.viewContact', compact('contact'));
    }

    public function getImageFile($filename)
    {
        $file = Storage::disk('local')->get($filename);
        return new Response($file, 200);
    }

    public function getImage($id)
    {
        $contact   = contacts::where('id', $id)->firstOrFail();
        $userImage = $contact->fotoPad;

        if (!file_exists(public_path() . '/imgs/contactImages/' . $userImage)) {
            return response()->file(public_path() . '/imgs/user.png');
        } else {
            return response()->file(public_path() . '/imgs/contactImages/' . $userImage);
        }
    }
}
