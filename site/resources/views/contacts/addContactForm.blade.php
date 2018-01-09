@extends('layouts.admin')
@section('content')
<script src="js/longlat.js"></script>
<script>
		var form;
	function getLongLat() {
		form = document.getElementById("addContact");
		console.log(form);
		//var form = document.forms['addContact'];
		var livingInfo = {
			straatnaam: form['straatnaam'].value,
			huisnummer: form['huisnummer'].value,
			plaats: form['plaats'].value,
			postcode: form['postcode'].value
		};
		var errorPlace404 = document.getElementById("errorPlace404");
		if (!getLongLang(livingInfo, errorPlace404)) {
			return true;
		} else {
			return false;
		}
	}

	function longLangCallback(latlng) {
		form['longtitude'].value = latlng.lng;
		form['latitude'].value = latlng.lat;
		form.submit();
	}
</script>

<div id="errorPlace404" class="alert alert-danger" style="display: none;">
    <strong>Error!</strong> { { session('error') }}
</div>

<form id="addContact" class="form-horizontal" name="addContact" action="{{ route('addContactPost') }}" method="post">
  {{ csrf_field() }}
  
  
	<label for="voornaam" class="col-md-4 control-label">Naam</label>
	<span class="col-md-6">
		<input class="form-control" type="text" name="voornaam" placeholder="voornaam">
	</span>
	<label for="tussenvoegsel" class="col-md-4 control-label">Tussenvoegsels</label>
	<span class="col-md-6">
		<input class="form-control" type="text" name="tussenvoegsel" placeholder="tussenvoegsel">
	</span>
	<label for="achternaam" class="col-md-4 control-label">Achternaam</label>
	<span class="col-md-6" style="padding-bottom: 16px;">
		<input class="form-control" type="text" name="achternaam" placeholder="achternaam">
	</span>
  
  
  
	<label for="date" class="col-md-4 control-label">Geboortedatum</label>
	<span class="col-md-6">
		<input class="form-control" type="date" name="geboortedatum" placeholder="geboortedatum">
	</span>
	<label for="telefoonnummer" class="col-md-4 control-label">Telefoonnummer</label>
	<span class="col-md-6">
		<input class="form-control" type="tel" name="telefoonnummer" placeholder="telefoonnummer">
	</span>
	<label for="email" class="col-md-4 control-label">Email</label>
	<span class="col-md-6">
		<input class="form-control" type="email" name="email" placeholder="email">
	</span>
	<label for="fotoPad" class="col-md-4 control-label">Foto file</label>
	<span class="col-md-6">
		<input class="form-control" type="text" name="fotoPad" value="/uploads/image.png">
	</span>
	<label for="beschrijving" class="col-md-4 control-label">Beschrijving</label>
	<span class="col-md-6" style="padding-bottom: 16px;">
		<input class="form-control" type="text" name="beschrijving" placeholder="beschrijving">
	</span>
  
  
	<label for="straatnaam" class="col-md-4 control-label">Straatnaam</label>
	<span class="col-md-6">
		<input class="form-control" type="text" name="straatnaam" placeholder="straatnaam">
	</span>
	<label for="huisnummer" class="col-md-4 control-label">Huisnummer</label>
	<span class="col-md-6">
		<input class="form-control" type="number" name="huisnummer" placeholder="huisnummer">
	</span>
	<label for="toevoeging" class="col-md-4 control-label">Toevoeging</label>
	<span class="col-md-6">
		<input class="form-control" type="text" name="toevoeging" placeholder="toevoeging">
	</span>
	<label for="postcode" class="col-md-4 control-label">Postcode</label>
	<span class="col-md-6">
		<input class="form-control" type="text" name="postcode" placeholder="postcode">
	</span>
	<label for="plaats" class="col-md-4 control-label">Plaats</label>
	<span class="col-md-6" style="padding-bottom: 16px;">
		<input class="form-control" type="text" name="plaats" placeholder="plaats">
	</span>
  
  <input type="hidden" name="longtitude">
  <input type="hidden" name="latitude">
  
    <div class="col-md-8 col-md-offset-4">
		<button type="submit" class="btn btn-primary" name="btnSubmit">
			Voeg contact toe
		</button>
	</div>
  
</form>
@endsection
