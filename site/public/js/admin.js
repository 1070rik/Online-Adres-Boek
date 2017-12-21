var selectedElements = [];
var currentHoveringRowElement;

var normalColor = '#FFF';
var hoverColor = '#EEE';
var selectedColor = '#DDD';

var shiftDown = false;
var controlDown = false;

var lastClickedIndex = 0;

$(document).keydown(function (e) {
    if (e.keyCode == 16) {
        shiftDown = true;
    } else if (e.keyCode == 17){
        controlDown = true;
    }
});

$(document).keyup(function (e) {
    if (e.keyCode == 16) {
        shiftDown = false;
    } else if (e.keyCode == 17){
        controlDown = false;
    }
});

$('.allDataBody > tr').hover(
    function(){
        $(this).css('background-color', hoverColor);
        currentHoveringRowElement = $(this);
    }, function(){
        if ($.inArray($(this).attr('id').replace(/\D/g,''), selectedElements) !== -1){
            $(this).css('background-color', selectedColor);
        } else {
            $(this).css('background-color', normalColor);
        }
    }
);

function getContactIndex(allContacts, contactID){
    for (var i = 0; i < allContacts.length; i++){
        if (allContacts[i]['id'] == contactID){
            return i;
        }
    }

    return -1;
}

function removeElement(id){

    var idToRemove = -1;

    for (var i = 0; i < selectedElements.length; i++){
        if (selectedElements[i] === id){
            idToRemove = i;
        }
    }

    if (idToRemove >= 0){
        selectedElements.splice(idToRemove, 1);
    }
}

function updateSelectionOutput(){
    $('#selectedCount').html(selectedElements.length + " selected");
}

function deselectAll(){
    $('.allDataBody > tr').css('background-color', normalColor);
    $('.allDataBody > tr > td').find('input').prop('checked', false);

    selectedElements = [];
    updateSelectionOutput();    
}

function selectAll(allContacts){
    for (var i = 0; i < allContacts.length; i++){
        selectedElements.push(allContacts[i]['id'].toString()   );
        $('.allDataBody > tr').css('background-color', hoverColor);
        $('.allDataBody > tr > td').find('input').prop('checked', true);
    }

    updateSelectionOutput();
}

function selectAllOrNone(allContacts){
    if (selectedElements.length > 0){
        deselectAll();
    } else {
        selectAll(allContacts);
    }
}

function remove(){

    var confirmedText = "";
    if (selectedElements.length == 0){
        alert("U heeft geen contact(en) geselecteerd.");
        return;
    } else if (selectedElements.length == 1){
        confirmedText = "Are you sure you want to delete this contact?";
    } else {
        confirmedText = "Are you sure you want to delete these " + selectedElements.length + " contacts?";
    }

    var confirmed = confirm(confirmedText);

    if (confirmed == true){
        $('#removeInput').val(JSON.stringify(selectedElements));

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

function normalClickOnRow(allContacts, row, checkBox, contact, address){
    deselectAll();

    if ($(checkBox).is(':checked')){
        $(checkBox).prop('checked', false);  
    } else {

        $(checkBox).prop('checked', true);

        selectedElements.push(contact['id'].toString());    

        $(row).css('background-color', hoverColor);
        updatePanelData(contact, address);

        lastClickedIndex = getContactIndex(allContacts, contact['id']);
    }    
}

function shiftClickOnRow(allContacts, endContact){
    document.getSelection().removeAllRanges();

    var minIndex = lastClickedIndex;
    var maxIndex = getContactIndex(allContacts, endContact['id']);
    var contact = null;
    var checkBox = "";
    var row = "";

    if (minIndex > maxIndex){
        maxIndex = [minIndex, minIndex = maxIndex][0];
    }

    deselectAll();

    for (var i = minIndex; i < maxIndex + 1; i++){
        contact = allContacts[i];
        checkBox = '#id' + contact['id'];
        row = '#row' + contact['id'];

        $(checkBox).prop('checked', true);

        selectedElements.push(contact['id'].toString());    

        $(row).css('background-color', selectedColor);
    }

    $(currentHoveringRowElement).css('background-color', hoverColor);
}

function controlClickOnRow(row, checkBox, contact, address){

    if ($(checkBox).is(':checked')){
        $(checkBox).prop('checked', false);  

        removeElement($(row).attr('id').replace(/\D/g,''));
        
    } else {

        $(checkBox).prop('checked', true);

        selectedElements.push(contact['id'].toString());    

        $(row).css('background-color', hoverColor);
        updatePanelData(contact, address);
    }
}

function clickOnRow(contacts, contact, address) {

    var checkBox = '#id' + contact['id'];
    var row = '#row' + contact['id'];

    if (shiftDown){
        shiftClickOnRow(contacts, contact);
    } else if (controlDown){
        controlClickOnRow(row, checkBox, contact, address);

    } else {
        normalClickOnRow(contacts, row, checkBox, contact, address);
    }

    updateSelectionOutput();
}