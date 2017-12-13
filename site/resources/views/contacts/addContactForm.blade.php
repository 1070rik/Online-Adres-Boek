<form action="{{ route('addContactPost') }}" method="post">
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
  <input type="text" name="longtitude" placeholder="longtitude"><br>
  <input type="text" name="latitude" placeholder="latitude"><br>
  <hr>
  <input type="submit" name="submit">
</form>
