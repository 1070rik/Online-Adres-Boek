function updateSelectionOutput(){
    $('#selectedCount').html(contactTable.selectedRowCount() + " selected");
}

function remove(){

    var selectedRowCount = contactTable.selectedRowCount();

    var confirmedText = "";
    if (selectedRowCount == 0){
        alert("U heeft geen contact(en) geselecteerd.");
        return;
    } else if (selectedRowCount == 1){
        confirmedText = "Are you sure you want to delete this contact?";
    } else {
        confirmedText = "Are you sure you want to delete these " + selectedRowCount + " contacts?";
    }

    var confirmed = confirm(confirmedText);

    if (confirmed == true){
        $('#removeInput').val(JSON.stringify(contactTable.getColumnDataFromRows("ID", contactTable.selectedItems)));

        document.forms['removeForm'].submit();
    }
}

function updatePanelData(contact, address){
    $('.profileTitle').html(contact['voornaam'] + ' ' + contact['tussenvoegsel'] + ' ' + contact['achternaam']);

    $('.id').val(contact['id']);
    $('.naam').val(contact['voornaam'] + ' ' + contact['tussenvoegsel'] + ' ' + contact['achternaam']);
    $('.voornaam').val(contact['voornaam']);
    $('.tussenvoegsel').val(contact['tussenvoegsel']);
    $('.achternaam').val(contact['achternaam']);
    $('.email').val(contact['email']);
    $('.telefoonnummer').val(contact['telefoonnummer']);
    $('.straatnaam').val(address['straatnaam']);
    $('.huisnummer').val(address['huisnummer']);
    $('.toevoeging').val(address['toevoeging']);
    $('.plaats').val(address['plaats']);
    $('.postcode').val(address['postcode']);
    $('.opmerking').val(contact['beschrijving']);
    $('.geboortedatum').val(contact['geboortedatum']);    
}

function getContactById(id){
    for (var i in allContacts){
        if (allContacts[i]['id'] == id){
            return allContacts[i];
        }
    }

    return null;
}

var contactTable;

document.addEventListener('DOMContentLoaded', constructContactTable, false);
function constructContactTable(){
    allContacts.forEach(function(contact){

        contact['naam'] = contact['voornaam'] + ' ';
        if (contact['tussenvoegsel'] !== ""){
            contact['naam'] += contact['tussenvoegsel'] + ' ';
        }
        contact['naam'] += contact['achternaam'];

        contact['adres'] = contact['addresses']['straatnaam'] + ' ' + contact['addresses']['huisnummer'];
        if (contact['addresses']['toevoeging'] !== null){
            contact['adres'] += contact['addresses']['toevoeging'];
        }

        contact['plaats'] = contact['addresses']['plaats'];

        contact['postcode'] = contact['addresses']['postcode'];
    });

    contactTable = new OrderedTable('allContacts',
                                    'contactTableTarget',
                                    { ID: 'id', 
                                      Naam: 'naam',
                                      Email: 'email',
                                      Adres: 'adres',
                                      Plaats: 'plaats',
                                      Postcode: 'postcode',
                                      Telefoon: 'telefoonnummer',
                                      Geboortejaar: 'geboortedatum'},
                                      allContacts
                                    );

    contactTable.print();

    contactTable.addEventListener("rowNormalClick", function(rowIndex){
        var id = contactTable.getColumnDataFromRow("ID", rowIndex);
        var contact = getContactById(id);

        updatePanelData(contact, contact['addresses']);
    });

    contactTable.addEventListener("rowClick", function(rowIndex){
        updateSelectionOutput();
    });
};