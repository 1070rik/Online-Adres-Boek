function returnOrUndefined(txt, extra, prefix) {
	if (extra === undefined) {
		extra = "";
	}
	if (prefix === undefined) {
		prefix = "";
	}
	if (txt !== undefined && txt !== null) {
		return prefix + txt + extra;
	} else {
		return "";
	}
}

function setSelectedContactsContent(markerObjs, showAllBool) {
	if(markerObjs.length == 1 && markerObjs[0].contacts.length == 1) {
		userInfo.innerHTML = "";
		var content = getSelectedContactContent(markerObjs[0].contacts[0], markerObjs[0].adres);
		userInfo.innerHTML = content;
		if(showAllBool===true && (viewType==1 || viewType == 3))
		{
			showAll();
		} else {
			showSelectedContact();
		}
	} else {
		contactsList.innerHTML = "";
		for(var i = 0; i < markerObjs.length; i++) {
			var markerObj = markerObjs[i];
			for(var j = 0; j < markerObj.contacts.length; j++) {
				var content = createCard(markerObj.contacts[j], markerObj.adres);
				contactsList.innerHTML += content;
			}
		}
		if(viewType != 3) {
			showAllContacts();
		}
	}
}

function getSelectedById(id) {
	var markerObj = markerObjs.find(function (obj) {
		for(var i = 0; i < obj.contacts.length; i++) {
			if(obj.contacts[i].id == id) {
				return true;
			}
		}
	});
	var contact = markerObj.contacts.filter(function (obj) {
		return obj.id == id;
	});
	var markerObjsNew = [new MarkerObj(markerObj.adres, contact)];
	setSelectedContactsContent(markerObjsNew, true);
}

function getSelectedContactContent(contact, adres) {
	var content = '<img src="';
	content += 'imgs/user.png';
	content += '" class="profile-pic"/><p class="name">'
	content += returnOrUndefined(contact.voornaam);
	content += returnOrUndefined(contact.tussenvoegsel, ""," ");
	content += returnOrUndefined(contact.achternaam, ""," ");
	content += '</p><div class="user-extra">';
	content += returnOrUndefined(contact.voornaam, '','Voornaam: ');
	content += returnOrUndefined(contact.tussenvoegsel, '','<br>TussenVoegsels: ');
	content += returnOrUndefined(contact.achternaam, '','<br>Achternaam: ');
	content += returnOrUndefined(adres.straatnaam, '', '<br>Adres: ');
	content += returnOrUndefined(adres.huisnummer,'', ' ');
	content += returnOrUndefined(adres.plaats, '', '<br>Plaats: ');
	content += returnOrUndefined(adres.postcode, '', '<br>Postcode: ');
	content += returnOrUndefined(contact.telefoonnummer, '','<br>Telefoonnummer: ');
	content += returnOrUndefined(contact.email, '','<br>E-mail: ');
	content += returnOrUndefined(contact.beschrijving, '</p>','<br><br><p id="beschrijving">Beschrijving: ');
	content += '</div>'
	return content;
}

function createCard(contact, adres) {
	var content = '<a onclick="getSelectedById(';
	content += contact.id
	content += ')"><div class="card"><div class="row"><div class="col-md-3"><div class="cardImage"><img src="';
	content += 'imgs/user.png';
	content += '"></div></div><div class="col-md-9"><div class="cardText"><h4 class="card-naam">';
	content += returnOrUndefined(contact.voornaam);
	content += returnOrUndefined(contact.tussenvoegsel, ""," ");
	content += returnOrUndefined(contact.achternaam, ""," ");
	content += '</h4><p class="card-address">';
	content += returnOrUndefined(adres.straatnaam);
	content += returnOrUndefined(adres.huisnummer,""," ");
	content += '</p><p class="card-address">';
	content += returnOrUndefined(adres.plaats);
	content += '</p></div></div></div></div></a>';
	return content;
}

function showAll() {
	var classAttr = mapDiv.getAttribute("class");	
	viewType = 3;
	if(classAttr == "onePanel") {
		mapDiv.setAttribute("class", "twoFastPanels");
	} else {
		mapDiv.setAttribute("class", "twoPanels");
	}
	selectedContact.setAttribute("class", "showContact");
	setTimeout(function() {
			google.maps.event.trigger(map, 'resize');
	}, 500);
}

function hideAll() {
	var classAttr = mapDiv.getAttribute("class");
	viewType = 0;
	if(classAttr == "onePanel") {
		mapDiv.setAttribute("class", "noFastPanel");
	} else {
		mapDiv.setAttribute("class", "noPanel");
	}
	selectedContact.setAttribute("class", "hideContact");
	setTimeout(function() {
			google.maps.event.trigger(map, 'resize');
	}, 500);
}

function showAllContacts() {
	var classAttr = mapDiv.getAttribute("class");
	viewType = 1;
	mapDiv.setAttribute("class", "onePanel");	
	selectedContact.setAttribute("class", "hideContact");
	setTimeout(function() {
			google.maps.event.trigger(map, 'resize');
	}, 500);
}

function showSelectedContact() {
	var classAttr = mapDiv.getAttribute("class");
	viewType = 2;
	mapDiv.setAttribute("class", "onePanel");	
	selectedContact.setAttribute("class", "showContact");
	setTimeout(function() {
			google.maps.event.trigger(map, 'resize');
	}, 500);
}

document.body.onload = function() {
	mapDiv = document.getElementById("mapDiv");
	selectedContact = document.getElementById("selectedContact");
	contactsList = document.getElementById("contactsList");
	userInfo = document.getElementById("userInfo");
	
}

var mapDiv, selectedContact, contactsList, userInfo;
var viewType = 0;