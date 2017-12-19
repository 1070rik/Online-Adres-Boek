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

<form id="addContact" name="addContact" action="{{ route('addContactPost') }}" method="post" onsubmit="return getLongLat()">
  {{ csrf_field() }}
  <input type="text" name="voornaam" placeholder="voornaam"><br>
  <input type="text" name="tussenvoegsel" placeholder="tussenvoegsel"><br>
  <input type="text" name="achternaam" placeholder="achternaam"><br>
  <input type="date" name="geboortedatum" placeholder="geboortedatum"><br>
  <input type="tel" name="telefoonnummer" placeholder="telefoonnummer"><br>
  <input type="email" name="email" placeholder="Email"><br>
  <input type="text" name="fotoPad" value="/uploads/image.png"><br>
  <input type="text" name="beschrijving" placeholder="beschrijving"><br>
  <hr>
  <input type="text" name="straatnaam" placeholder="straatnaam"><br>
  <input type="number" name="huisnummer" placeholder="huisnummer"><br>
  <input type="text" name="toevoeging" placeholder="toevoeging"><br>
  <input type="text" name="postcode" placeholder="postcode"><br>
  <input type="text" name="plaats" placeholder="plaats"><br>
  <input type="hidden" name="longtitude"><br>
  <input type="hidden" name="latitude"><br>
  <hr>
  <input type="submit" name="btnSubmit">
</form>
