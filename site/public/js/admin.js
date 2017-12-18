function getData(contact, addres) {
  contact.tussenvoegsel.length<1&&(contact.tussenvoegsel="N/A");
  $('.naam').text(contact['voornaam'] + ' ' + contact['tussenvoegsel'] + ' ' + contact['achternaam']);
  $('.voornaam').text(contact['voornaam']);
  $('.tussenvoegsel').text(contact['tussenvoegsel']);
  $('.achternaam').text(contact['achternaam']);
  $('.telefoonnummer').text(contact['telefoonnummer']);
  $('.adres').text(addres['straatnaam'] + ' ' + addres['huisnummer']);
  $('.plaats').text(addres['plaats']);
  $('.postcode').text(addres['postcode']);
  $('.opmerking').text(contact['beschrijving']);
}
