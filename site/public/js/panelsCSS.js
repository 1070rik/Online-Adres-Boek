function showAll() {
	var classAttr = mapDiv.getAttribute("class");
	if(classAttr == "onePanel") {
		mapDiv.setAttribute("class", "twoFastPanels");
	} else {
		mapDiv.setAttribute("class", "twoPanels");
	}
	selectedContact.setAttribute("class", "showContact");
}

function hideAll() {
	var classAttr = mapDiv.getAttribute("class");
	if(classAttr == "onePanel") {
		mapDiv.setAttribute("class", "noFastPanel");
	} else {
		mapDiv.setAttribute("class", "noPanel");
	}
	selectedContact.setAttribute("class", "hideContact");
}

function showAllContacts() {
	var classAttr = mapDiv.getAttribute("class");
	mapDiv.setAttribute("class", "onePanel");	
	selectedContact.setAttribute("class", "hideContact");
}

function showSelectedContact() {
	var classAttr = mapDiv.getAttribute("class");
	mapDiv.setAttribute("class", "onePanel");	
	selectedContact.setAttribute("class", "showContact");
}

document.body.onload = function() {
	mapDiv = document.getElementById("mapDiv");
	selectedContact = document.getElementById("selectedContact");
	
}

var mapDiv, selectedContact;