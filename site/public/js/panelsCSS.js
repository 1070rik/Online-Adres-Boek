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
	content += returnOrUndefined(contact.voornaam, '</h6>','<h4>Voornaam<h4> <h6> ');
	content += returnOrUndefined(contact.tussenvoegsel, '</h6>','<h4>TussenVoegsels</h4> <h6>');
	content += returnOrUndefined(contact.achternaam, '</h6>','<h4>Achternaam</h4> <h6>');
	content += returnOrUndefined(adres.straatnaam, '</h6>', '<h4>Adres</h4> <h6>');
	content += returnOrUndefined(adres.huisnummer,'</h6>', ' ');
	content += returnOrUndefined(adres.plaats, '</h6>', '<h4>Plaats</h4> <h6>');
	content += returnOrUndefined(adres.postcode, '</h6>', '<h4>Postcode</h4> <h6>');
	content += returnOrUndefined(contact.telefoonnummer, '','<h4>Telefoonnummer</h4> <h6>');
	content += returnOrUndefined(contact.email, '</h6>','<h4>E-mail</h4> <h6>');
	content += returnOrUndefined(contact.beschrijving, '</p></h6>','<h4><p id="beschrijving">Beschrijving</h4> <h6>');
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

function hideAllContacts() {
	var classAttr = mapDiv.getAttribute("class");
	if(viewType == 3) {
		viewType = 2;
		mapDiv.setAttribute("class", "onePanel");
	} else if (viewType ==  1) {
		viewType = 0;
		mapDiv.setAttribute("class", "noFastPanel");
	}
	setTimeout(function() {
		google.maps.event.trigger(map, 'resize');
	}, 500);
}

function hideSelectedContact() {
	var classAttr = mapDiv.getAttribute("class");
	if(viewType == 3) {
		viewType = 1;
		mapDiv.setAttribute("class", "onePanel");
	} else if (viewType ==  2) {
		viewType = 0;
		mapDiv.setAttribute("class", "noFastPanel");
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
