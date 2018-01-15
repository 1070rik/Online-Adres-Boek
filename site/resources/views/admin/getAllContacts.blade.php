@extends('layouts.admin')

@section('content')



    <div class="row">
        <div class="col-md-9 content">

        @if(session('error'))
            <div class="alert alert-danger">
                <strong>Error!</strong> {{ session('error') }}
            </div>
        @endif

          <div class="pageHeader">
            <div class="headerLeft">
              <h1 class="pageTitle">Contacten</h1>
            </div>
            <div class="headerRight">
              <span><a href="{{ route('addContactGet') }}">New</a></span>
              <span id="selectAll"><a href="#" onclick="selectAllOrNone()" >Un(select) all</a></span>
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
          <div id="contactTableTarget">

          </div>



        </div>
        <div class="col-md-3 userData">
          <img src="{{ asset('imgs/user.png') }}" alt="profileImage" class="profileImage">
          <p class="naam profileTitle">....</p>

          <form class="form-vertical" method="POST" action="{{ route('editContactPost') }}" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="data">
              <table class="table">
                <tbody>
                <tr class="form-group">
                  <td>Contact foto</td>
                  <td><input class="form-control" type="file" name="fotoPad"></td>
                </tr>
                <tr class="form-group">
                  <td>Id</td>
                  <td class="tdid"></td>
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
                  <td>Postcode</td>
                  <td><input class="postcode" type="text" name="postcode" /></td>
                </tr>
                <tr class="form-group">
                  <td>Beschrijving</td>
                  <td><input class="opmerking" type="text" name="beschrijving" /></td>
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

    <script src="{{ asset('js/orderedTable.js') }}?v=<?=time()?>" charset="utf-8"></script>
@endsection

@section('scripts')
<script src="{{ asset('js/admin.js') }}?v=<?=time()?>" charset="utf-8"></script>
@endsection
