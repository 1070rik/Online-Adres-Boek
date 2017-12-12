@extends('layouts.app')

@section('content')
  <div class="row">
    <div class="col-md-8 col-md-offset-2">
      <div class="panel panel-default">
        <!-- Default panel contents -->
        <div class="panel-heading">Zoek resultaten</div>
        <div class="panel-body">
          <table class="table">
            <thead>
              <th>Naam</th>
              <th>Adres</th>
              <th>Plaats, postcode</th>
              <th colspan="1"></th>
            </thead>
            <tbody>
              @foreach($addresses as $address)
              <tr>
                <td>{{ $address->voornaam }}, {{ $address->tussenvoegsel }} {{ $address->achternaam }}</td>
                <td>{{ $address->straatnaam }} {{ $address->huisnummer }}</td>
                <td>{{ $address->plaats }} {{ $address->postcode }}</td>
                <td><a href="{{ route('viewContactGet', $address->id) }}" target="_blank"><button type="button" name="button" class="btn btn-success">View</button></a></td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
@endsection
