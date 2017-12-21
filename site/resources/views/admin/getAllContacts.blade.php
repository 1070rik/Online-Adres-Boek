@extends('layouts.admin')

@section('content')

    <div class="row">
        <div class="col-md-9 content">

        @if(session('error'))
            <div class="alert alert-danger">
                <strong>Error!</strong> { { session('error') }}
            </div>
        @endif

          <div class="pageHeader">
            <div class="headerLeft">
              <h1 class="pageTitle">Contacten</h1>
            </div>
            <div class="headerRight">
              <span><a href="{{ route('addContactGet') }}">New</a></span>
              <span id="selectAll"><a href="#" onclick="selectAllOrNone({{ $contacts }})" >Un(select) all</a></span>
              <span>
                <form name="removeForm" action="{{ route('removeContacts') }}" method="post">
                  {{ csrf_field() }}

                  <input id="removeInput" type="hidden" name="toDeleteElements" value="" />
                  <a href="#" onclick="remove()">Remove</a>

                </form>
              </span>
              <span id="selectedCount">0 Selected</span>
            </div>
          </div>
            <table class="table">
                <thead>
                    <th>ID</th>
                    <th>Naam</th>
                    <th>Email</th>
                    <th>Adres</th>
                    <th>Plaats</th>
                    <th>Postcode</th>
                    <th>Telefoon</th>
                    <th>Geboortejaar</th>
                </thead>
                <tbody class="allDataBody">
                  @foreach($contacts as $contact)
                    <tr id="{{ 'row' . $contact->id }}" onclick="clickOnRow({{ $contacts }}, {{ $contact }}, {{ $contact->addresses }})">
                      <td>
                        <input id="{{ 'id' . $contact->id }}" type="checkbox" name="userId" value="{{ $contact->id }}">
                        {{ $contact->id }}
                      </td>
                      <td>
                        {{ $contact->voornaam }} 
                        @if (strlen($contact->tussenvoegsel) > 0)
                        {{ $contact->tussenvoegsel}}
                        @endif
                        {{ $contact->achternaam }}                         
                      </td>
                      <td>
                        {{ $contact->email }}
                      </td>
                      <td>
                        {{ $contact->addresses->straatnaam }} {{ $contact->addresses->huisnummer }} {{ $contact->addresses->toevoeging }}
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
                      <td>
                        {{ $contact->geboortedatum }}
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
        <div class="col-md-3 userData">
          <img src="http://via.placeholder.com/200x200" alt="profileImage" class="profileImage">
          <p class="naam profileTitle">....</p>

          <form class="form-vertical" method="POST" action="{{ route('editContactPost') }}">
            {{ csrf_field() }}
            <div class="data">
              <table class="table">
                <tbody>
                <tr class="form-group">
                  <td>Id</td>
                  <td><input class="id" type="text" name="id" readonly value=""/></td>
                </tr>
                <tr class="form-group">
                  <td>Voornaam</td>
                  <td><input class="voornaam" type="text" name="voornaam" /></td>
                </tr>
                <tr class="form-group">
                  <td>Tussenvoegsel</td>
                  <td><input class="tussenvoegsel" type="text" name="tussenvoegsel" /></td>
                </tr>
                <tr class="form-group">
                  <td>Achternaam</td>
                  <td><input class="achternaam" type="text" name="achternaam" /></td>
                </tr>
                <tr class="form-group">
                  <td>Email</td>
                  <td><input class="email" type="email" name="email" /></td>
                </tr>
                <tr class="form-group">
                  <td>Telefoonnummer</td>
                  <td><input class="telefoonnummer" type="text" name="telefoonnummer" /></td>
                </tr>
                <tr class="form-group">
                  <td>Straatnaam</td>
                  <td><input class="straatnaam" type="text" name="straatnaam" /></td>
                </tr>
                <tr class="form-group">
                  <td>Huisnummer</td>
                  <td><input class="huisnummer" type="text" name="huisnummer" /></td>
                </tr>
                <tr class="form-group">
                  <td>Toevoeging</td>
                  <td><input class="toevoeging" type="text" name="toevoeging" /></td>
                </tr>
                <tr class="form-group">
                  <td>Plaats</td>
                  <td><input class="plaats" type="text" name="plaats" /></td>
                </tr>
                <tr class="form-group">
                  <td>Postcodde</td>
                  <td><input class="postcode" type="text" name="postcode" /></td>
                </tr>
                <tr class="form-group">
                  <td>Beschrijving</td>
                  <td><input class="opmerking" type="text" name="Beschrijving" /></td>
                </tr>
                <tr class="form-group">
                  <td>Geboortedatum</td>
                  <td><input class="geboortedatum" type="text" name="geboortedatum" /></td>
                </tr>
                <tr class="form-group">
                  <td></td>
                  <td><input type="submit" value="Edit" /></td>
                </tr> 
              </tbody>
            </table>
            </div>
          </form>
        </div>
    </div>
@endsection
