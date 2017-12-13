@extends('layouts.app')

@section('content')


<div class="row">
  <div class="col-md-8 col-md-offset-2">
    <div class="panel panel-default">
      <!-- Default panel contents -->
      <div class="panel-heading">Zoeken</div>
      <div class="panel-body">
        <form action="{{route("searchPost")}}" method="post">
          <input name="_token" value="{{csrf_token()}}" type="hidden">
          <input type="hidden" name="api" value="1">
          Voornaam: <input type="text" name="voornaam"><br>
          tussenvoegsel: <input type="text" name="tussenvoegsel"><br>
          Achternaam: <input type="text" name="achternaam"><br>
          Straatnaam: <input type="text" name="straatnaam"><br>
          Huisnummer: <input type="text" name="huisnummer"><br>
          Plaats: <input type="text" name="plaats"><br>
          Postcode: <input type="text" name="postcode"><br>
          <input type="submit" class="btn btn-primary" value="zoeken">
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
