@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-xs-12 col-sm-6 col-md-6">
            <div class="well well-sm">
                <div class="row">
                    <div class="col-sm-6 col-md-4">
                        <img src="http://placehold.it/380x500" alt="" class="img-rounded img-responsive" />
                    </div>
                    <div class="col-sm-6 col-md-8">
                        <h4>
                            {{ $contact->voornaam }}, {{ $contact->tussenvoegsel }} {{ $contact->achternaam }}</h4>
                        <p>
                            <b>Voornaam:</b><br>
                            {{ $contact->voornaam }}
                            <br />
                            <b>tussenvoegsel:</b><br>
                            {{ $contact->tussenvoegsel }}
                            <br />
                            <b>Achternaam:</b><br>
                            {{ $contact->achternaam }}
                            <br>
                            <b>telefoonnummer:</b><br>
                            {{ $contact->telefoonnummer }}
                            <br>
                            <b>Adres:</b><br>
                            {{ $contact->straatnaam }} {{ $contact->huisnummer }}
                            <br>
                            <b>Plaats</b><br>
                            {{ $contact->plaats }}
                            <br>
                            <b>Postcode</b><br>
                            {{ $contact->postcode }}
                            <br>
                            <b>Opmerking</b><br>
                            {{ $contact->beschrijving }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
