<?php

namespace AdresBoek;

class CoordsHandler
{

    /*
     * Check all addresses in the database and insert the coords when needed
     */
    public static function fillAllAddressesCoords()
    {
        $addresses = addresses::get();

        foreach ($addresses as $address) {
            if (strlen($address->longitude) == 0 || (strlen($address->latitude) == 0)) {
                $coords = CoordsHandler::getGeoCoords($address->straatnaam . ' ' . $address->huisnummer . ' ' . $address->toevoeging . '+' . $address->postcode . '+' . $address->plaats);

                $longitude = $coords['lng'];
                $latitude  = $coords['lat'];

                Addresses::where('id', $address->id)->update(['longitude' => $longitude, 'latitude' => $latitude]);
            }
        }
    }

    public static function getGeoCoords($address)
    {
        return CoordsHandler::getGeoPosition($address)['geometry']['location'];
    }

    public static function getGeoPosition($address)
    {
        $url = "https://maps.google.com/maps/api/geocode/json?sensor=false" .
        "&key=AIzaSyDKZlYb-j15azWaz3lQxTcEzYE7P43S3kU" .
        "&address=" . urlencode($address);

        $json = file_get_contents($url);

        $data = json_decode($json, true);

        if ($data['status'] == "OK") {
            return $data['results'][0];
        }
    }
}
