function showAll() {
	var classAttr = map.getAttribute("class");
	if(classAttr == "onePanel") {
		map.setAttribute("class", "twoFastPanels");
	} else {
		map.setAttribute("class", "twoPanels");
	}
	selectedContact.setAttribute("class", "showContact");
}

function hideAll() {
	var classAttr = map.getAttribute("class");
	if(classAttr == "onePanel") {
		map.setAttribute("class", "noFastPanel");
	} else {
		map.setAttribute("class", "noPanel");
	}
	selectedContact.setAttribute("class", "hideContact");
}

function showAllContacts() {
	var classAttr = map.getAttribute("class");
	map.setAttribute("class", "onePanel");	
	selectedContact.setAttribute("class", "hideContact");
}

function showSelectedContact() {
	var classAttr = map.getAttribute("class");
	map.setAttribute("class", "onePanel");	
	selectedContact.setAttribute("class", "showContact");
}

document.body.onload = function() {
	map = document.getElementById("mapDiv");
	selectedContact = document.getElementById("selectedContact");
	
}

var map, selectedContact;