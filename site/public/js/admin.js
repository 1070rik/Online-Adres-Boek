var selectedElements = [];

var normalColor = '#FFF';
var hoverColor = '#EEE';
var selectedColor = '#DDD';


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

function selectAll(allContacts){
    if (selectedElements.length > 0){
        $('.allDataBody > tr').css('background-color', normalColor);
        $('.allDataBody > tr > td').find('input').prop('checked', false);

        selectedElements = [];
        updateSelectionOutput();
    } else {
        for (var i = 0; i < allContacts.length; i++){
            selectedElements.push(allContacts[i]['id'].toString());
            $('.allDataBody > tr').css('background-color', hoverColor);
            $('.allDataBody > tr > td').find('input').prop('checked', true);
        }

        updateSelectionOutput();
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

function getData(contact, addres) {

    var checkBox = '#id' + contact['id'];
    var row = '#row' + contact['id'];

    if ($(checkBox).is(':checked')){
        $(checkBox).prop('checked', false);      

        removeElement($(row).attr('id').replace(/\D/g,''));
    } else {
        $(checkBox).prop('checked', true);

        selectedElements.push($(row).attr('id').replace(/\D/g,''));    
    }

    updateSelectionOutput();

    $('.id').val(contact['id']);
    $('.naam').val(contact['voornaam'] + ' ' + contact['tussenvoegsel'] + ' ' + contact['achternaam']);
    $('.voornaam').val(contact['voornaam']);
    $('.tussenvoegsel').val(contact['tussenvoegsel']);
    $('.achternaam').val(contact['achternaam']);
    $('.email').val(contact['email']);
    $('.telefoonnummer').val(contact['telefoonnummer']);
    $('.straatnaam').val(addres['straatnaam']);
    $('.huisnummer').val(addres['huisnummer']);
    $('.toevoeging').val(addres['toevoeging']);
    $('.plaats').val(addres['plaats']);
    $('.postcode').val(addres['postcode']);
    $('.opmerking').val(contact['beschrijving']);
    $('.geboortedatum').val(contact['geboortedatum']);
}

$('.allDataBody > tr').hover(
    function(){
        $(this).css('background-color', hoverColor);
    }, function(){
        if ($.inArray($(this).attr('id').replace(/\D/g,''), selectedElements) !== -1){
            $(this).css('background-color', selectedColor);
        } else {
            $(this).css('background-color', normalColor);
        }
    }
);