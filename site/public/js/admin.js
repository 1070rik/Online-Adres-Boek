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

    $('.tdid').html('<input type="hidden" class="id" type="text" name="id" readonly value="' + contact['id'] + '"/>' + contact['id']);
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

function selectAllOrNone(){
    contactTable.currentHoveringRowIndex = -1;

    if (contactTable.selectedRowCount() > 0){
        contactTable.clearSelection();
    } else {
        contactTable.selectAllRows();
    }

    contactTable.updateRowSelectionStyle();
    updateSelectionOutput();
}

function getContactById(allContacts, id){
    for (var i in allContacts){
        if (allContacts[i]['id'] == id){
            return allContacts[i];
        }
    }

    return null;
}

function getAllContactData(){
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            var allContactsJson = JSON.parse(this.response);
            constructContactTable(combineAdrAndCon(allContactsJson));
        }
    };
    var requestUrl = "/getAllContactsAjax";

    xhttp.open("POST", requestUrl, true);
    xhttp.send();
}

function combineAdrAndCon(adrAndCon) {
    for (var i = 0; i < adrAndCon.contacts.length; i++) {
        var contact = adrAndCon.contacts[i];
        var contactAddress = adrAndCon.addresses.find(function (obj) {
            return obj.id == contact.adresID;
        });

        adrAndCon['contacts'][i]['addresses'] = contactAddress;
    }

    return adrAndCon['contacts'];
}

var contactTable;
var _allContacts;

document.addEventListener('DOMContentLoaded', getAllContactData, false);
function constructContactTable(allContacts){

    _allContacts = allContacts;

    for (var i in allContacts){
        let contact = allContacts[i];

        //Remove null values
        for (var j in contact){
            if (j == "addresses"){
                for (var k in contact[j]){
                    if (contact[j][k] == null){
                        contact[j][k] = "";
                    }
                }
            } else {
                if (contact[j] == null){
                    contact[j] = "";
                }
            }
        }

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
    }   

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
        var contact = getContactById(allContacts, id);

        updatePanelData(contact, contact['addresses']);
    });

    contactTable.addEventListener("rowClick", function(rowIndex){
        updateSelectionOutput();
    });

};