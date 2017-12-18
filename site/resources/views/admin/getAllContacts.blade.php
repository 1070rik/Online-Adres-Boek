@extends('layouts.admin')

@section('content')
    <div class="row">
        <div class="col-md-10">
          <div class="pageHeader">
            <div class="headerLeft">
              <h1 class="pageTitle">Contacten</h1>
            </div>
            <div class="headerRight">
              <span>Un(select) all</span>
              <span>Remove</span>
              <span>0 Selected</span>
            </div>
          </div>
            <table class="table">
                <thead>
                    <th>ID</th>
                    <th>Voornaam</th>
                    <th>tussenvoegsel</th>
                    <th>Achternaam</th>
                    <th>Adres</th>
                    <th>Plaats</th>
                    <th>Postcode</th>
                    <th>Telefoon</th>
                </thead>
                <tbody>
                  @foreach($contacts as $contact)
                    <tr onclick="getData({{ $contact }}, {{ $contact->addresses }})">
                      <td>
                        <input type="checkbox" name="userId" value="{{ $contact->id }}">
                        {{ $contact->id }}
                      </td>
                      <td>
                        {{ $contact->voornaam }}
                      </td>
                      <td>
                        {{ $contact->tussenvoegsel }}
                      </td>
                      <td>
                        {{ $contact->achternaam }}
                      </td>
                      <td>
                        {{ $contact->addresses->plaats }}
                      </td>
                      <td>
                        {{ $contact->addresses->plaats }}
                      </td>
                      <td>
                        {{ $contact->addresses->postcode }}
                      </td>
                      <td>
                        {{ $contact->telefoonnummer }}
                      </td>
                    </tr>
                  @endforeach
                </tbody>
            </table>

             <!-- <div class="tr">
                 <span class="td col-md-1">ID</span>
                 <span class="td col-md-1">Voornaam</span>
                 <span class="td col-md-1">tussenvoegsel</span>
                 <span class="td col-md-2">Achternaam</span>
                 <span class="td col-md-1">Geboortedatum</span>
                 <span class="td col-md-1">Telefoonnummer</span>
                 <span class="td col-md-1">Email</span>
                 <span class="td col-md-1">fotoPad</span>
                 <span class="td col-md-1">Beschrijving</span>
             </div> -->


        </div>
        <div class="col-md-2 userData">
          <img src="http://via.placeholder.com/200x200" alt="profileImage" class="profileImage">
          <p class="naam profileTitle">....</p>
          <div class="data">
            <span><b>Voornaam</b></span>
            <p class="voornaam">....</p>
            <span><b>tussenvoegsel</b></span>
            <p class="tussenvoegsel">....</p>
            <span><b>Achternaam</b></span>
            <p class="achternaam">....</p>
            <span><b>Telefoonnummer</b></span>
            <p class="telefoonnummer">....</p>
            <span><b>Adres</b></span>
            <p class="adres">....</p>
            <span><b>Plaats</b></span>
            <p class="plaats">....</p>
            <span><b>Postcode</b></span>
            <p class="postcode">....</p>
            <span><b>Opmerking</b></span>
            <p class="opmerking">....</p>
          </div>
        </div>
    </div>
@endsection
