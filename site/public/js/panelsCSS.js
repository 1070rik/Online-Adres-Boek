//Poly filling find function for older browsers
if (!Array.prototype.find) {
  Object.defineProperty(Array.prototype, 'find', {
    value: function(predicate) {
     // 1. Let O be ? ToObject(this value).
      if (this == null) {
        throw new TypeError('"this" is null or not defined');
      }

      var o = Object(this);

      // 2. Let len be ? ToLength(? Get(O, "length")).
      var len = o.length >>> 0;

      // 3. If IsCallable(predicate) is false, throw a TypeError exception.
      if (typeof predicate !== 'function') {
        throw new TypeError('predicate must be a function');
      }

      // 4. If thisArg was supplied, let T be thisArg; else let T be undefined.
      var thisArg = arguments[1];

      // 5. Let k be 0.
      var k = 0;

      // 6. Repeat, while k < len
      while (k < len) {
        // a. Let Pk be ! ToString(k).
        // b. Let kValue be ? Get(O, Pk).
        // c. Let testResult be ToBoolean(? Call(predicate, T, « kValue, k, O »)).
        // d. If testResult is true, return kValue.
        var kValue = o[k];
        if (predicate.call(thisArg, kValue, k, o)) {
          return kValue;
        }
        // e. Increase k by 1.
        k++;
      }

      // 7. Return undefined.
      return undefined;
    }
  });
}

//Return the text if it isnt undefined and put something in front and/or behind it
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
	//Check if more contacts detected
	if(markerObjs.length == 1 && markerObjs[0].contacts.length == 1) {
		//Set content of userInfo
		userInfo.innerHTML = "";
		var content = getSelectedContactContent(markerObjs[0].contacts[0], markerObjs[0].adres);
		userInfo.innerHTML = content;
		
		//Check if to open 2 or one panel
		if(showAllBool===true && (viewType==1 || viewType == 3))
		{
			showAll();
		} else {
			showSelectedContact();
		}
	} else {
		//checks if there are any users found
		allContactsList.classList.remove("hidden");
		if(markerObjs.length == 0) {
			contactsList.innerHTML = '<p id="noneFound">We konden niemand vinden die aan deze zoek resultaten voldoet.</p>';
		} else {
			contactsList.innerHTML = "";
		}
		
		//if users found loop trough all markerObjs if a cluster marker and add all contacts from it as content
		for(var i = 0; i < markerObjs.length; i++) {
			var markerObj = markerObjs[i];
			for(var j = 0; j < markerObj.contacts.length; j++) {
				var content = createCard(markerObj.contacts[j], markerObj.adres);
				contactsList.innerHTML += content;
			}
		}
		
		//If mobile phone or isnt showing all show both panels
		if(viewType != 3 || document.documentElement.clientWidth < 768) {
			showAllContacts();
		}
	}
}

function getSelectedById(id) {
	//search for the contact in the markerObjs
	var markerObj = markerObjs.find(function (obj) {
		for(var i = 0; i < obj.contacts.length; i++) {
			if(obj.contacts[i].id == id) {
				return true;
			}
		}
	});
	
	//Check if id == obj.id and show the user
	var contact = markerObj.contacts.filter(function (obj) {
		return obj.id == id;
	});
	var markerObjsNew = [new MarkerObj(markerObj.adres, contact)];
	setSelectedContactsContent(markerObjsNew, true);
}

function getSelectedContactContent(contact, adres) {
	//Get fotoPath and set default tussenvoegsel
	var fotoPath =  '/getImage/' + contact.id;
	var tussenvoegsel = "-";
	console.log(fotoPath);

	//
	if(contact.tussenvoegsel >= 1) {
		tussenvoegsel = contact.tussenvoegsel;
	}
	//Add all html to content
	var content = '<img src="';
	content += fotoPath;
	content += '" class="profile-pic"/><p class="name">'
	content += returnOrUndefined(contact.voornaam);
	content += returnOrUndefined(contact.tussenvoegsel, ""," ");
	content += returnOrUndefined(contact.achternaam, ""," ");
	content += '</p><div class="user-extra">';
	content += returnOrUndefined(contact.voornaam, '</h6>','<h4>Voornaam<h4> <h6> ');
	content += returnOrUndefined(tussenvoegsel, '</h6>','<h4>Tussenvoegsels</h4> <h6>');
	content += returnOrUndefined(contact.achternaam, '</h6>','<h4>Achternaam</h4> <h6>');
	content += returnOrUndefined(adres.straatnaam + ' ' + adres.huisnummer, '</h6>', '<h4>Adres</h4> <h6>');
	content += returnOrUndefined(adres.plaats, '</h6>', '<h4>Plaats</h4> <h6>');
	content += returnOrUndefined(adres.postcode, '</h6>', '<h4>Postcode</h4> <h6>');
	content += returnOrUndefined(contact.telefoonnummer, '','<h4>Telefoonnummer</h4> <h6>');
	content += returnOrUndefined(contact.email, '</h6>','<h4>E-mail</h4> <h6>');
	content += returnOrUndefined(contact.beschrijving, '</p></h6>','<h4><p id="beschrijving">Beschrijving</h4> <h6>');
	content += '</div>'
	return content;
}

function createCard(contact, adres) {
	//Add all html to content
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
	//Opens both panels by setting the right classes for it
	var classAttr = mapDiv.getAttribute("class");
	viewType = 3;

	if(document.documentElement.clientWidth < 768) {
		//Mobile screen
		if(classAttr == "onePanel") {
			mapDiv.setAttribute("class", "twoFastPanels");
		} else {
			mapDiv.setAttribute("class", "twoPanels");
		}
			allContactsList.setAttribute("class", "hidden");
		selectedContact.setAttribute("class", "showContact vh60");
		setTimeout(function() {
				google.maps.event.trigger(map, 'resize');
		}, 500);
	}else{
		//Not a mobile screen
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
}

function hideAll() {
	//Hides both panels by setting the right classes for it
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
	//Hide only one panel by setting the right classes for it
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
	//Hide only one panel by setting the right classes for it
	var classAttr = mapDiv.getAttribute("class");
	if(viewType == 3) {
		viewType = 1;
		selectedContact.setAttribute("class", "hidden");
		allContacts.classList.remove("hidden");
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
	//Shows only one panel by setting the right classes for it
	var classAttr = mapDiv.getAttribute("class");
	viewType = 1;
	mapDiv.setAttribute("class", "onePanel");
	selectedContact.setAttribute("class", "hideContact");
	setTimeout(function() {
			google.maps.event.trigger(map, 'resize');
	}, 500);
	
	console.log("test");
}

function showSelectedContact() {
	//Shows only one panel by setting the right classes for it
	var classAttr = mapDiv.getAttribute("class");
	viewType = 2;
	if(document.documentElement.clientWidth < 768) {
		//mobile screen
		selectedContact.setAttribute("class", "showContact vh60");
		mapDiv.setAttribute("class", "twoPanels");
	} else {
		//Not a mobile screen
		selectedContact.setAttribute("class", "showContact");
		mapDiv.setAttribute("class", "onePanel");
	}
	allContactsList.setAttribute("class", "hidden");
	setTimeout(function() {
			google.maps.event.trigger(map, 'resize');
	}, 500);
}

window.addEventListener("resize", function() {
		//Re runs functions when view changed
		allContactsList.classList.remove("hidden");
		if(viewType == 0) {
			hideAll();
		} else if(viewType == 1) {
			showAllContacts()
		} else if(viewType == 2) {
			showSelectedContact() 
		} else if(viewType == 3) {
			showAll();
		}
});

document.body.onload = function() {
	//Set all element variables
	mapDiv = document.getElementById("mapDiv");
	selectedContact = document.getElementById("selectedContact");
	contactsList = document.getElementById("contactsList");
	allContactsList = document.getElementById("allContacts");
	userInfo = document.getElementById("userInfo");
}

var mapDiv, selectedContact, contactsList, userInfo;
var viewType = 0;
