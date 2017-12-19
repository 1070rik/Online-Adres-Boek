function roundHalf(number) {
	return Math.round(number*2)/2;
}

function hideBoth() {
	windowType = 0;
	var myInterval = setInterval(function () {
		var width = roundHalf(parseFloat(mapDiv.style.width.replace("vw", "")));
		var right = roundHalf(parseFloat(selectedContact.style.right.replace("vw", "")));
		google.maps.event.trigger(map, 'resize');
		if((width == 100 && right == -20) || windowType != 0) {
			if(windowType == 0) {
				clearInterval(myInterval);
			}
		}
		
		if(width < 100 && windowType == 0) {
			mapDiv.style.width = roundHalf(width+0.5)+"vw";
		} else if(width > 100 && windowType == 0) {
			mapDiv.style.width = roundHalf(width-0.5)+"vw";
		}
		
		if(right < -20 && windowType == 0) {
			selectedContact.style.right = roundHalf(right+0.5)+"vw";
		} else if(right > -20 && windowType == 0) {
			selectedContact.style.right = roundHalf(right-0.5)+"vw";
		}
	}, 1);
}

function both() {
	windowType = 1;
	var myInterval = setInterval(function () {
		var width = roundHalf(parseFloat(mapDiv.style.width.replace("vw", "")));
		var right = roundHalf(parseFloat(selectedContact.style.right.replace("vw", "")));
		google.maps.event.trigger(map, 'resize');
		if((width == 60 && right == 0) || windowType != 1){
			if(windowType == 1) {
			}
			clearInterval(myInterval);
		}
		
		if(width < 60 && windowType==1) {
			mapDiv.style.width = roundHalf(width+0.5)+ "vw";
		} else if( width > 60 && windowType == 1) {
			mapDiv.style.width = roundHalf(width-0.5)+ "vw";
		} 
		
		if(right < 0 && windowType == 1) {
			selectedContact.style.right = roundHalf(right+0.5)+"vw";
		} else if(right > 0 && windowType == 1) {
			selectedContact.style.right = roundHalf(right-0.5)+"vw";
		}
	}, 1);
}

function showAllContacts() {
	windowType = 2;
	var myInterval = setInterval(function() {
		var width = roundHalf(parseFloat(mapDiv.style.width.replace("vw", "")));
		var right = roundHalf(parseFloat(selectedContact.style.right.replace("vw", "")));
		google.maps.event.trigger(map, 'resize');
		if((width == 80 && right==-20) || windowType != 2) {
			clearInterval(myInterval);
		}
		
		if(width < 80&& windowType==2) {
			mapDiv.style.width = roundHalf(width+0.5)+ "vw";
		} else if(width > 80 && windowType==2) {
			mapDiv.style.width = roundHalf(width-0.5)+ "vw";
		}
		
		if(right < -20 && windowType == 2) {
			selectedContact.style.right = roundHalf(right+0.5)+"vw";
		} else if(right > -20 && windowType == 2) {
			selectedContact.style.right = roundHalf(right-0.5)+"vw";
		}
	}, 1);
}

function showContact() {
	windowType = 3;
	var myInterval = setInterval(function() {
		var width = roundHalf(parseFloat(mapDiv.style.width.replace("vw", "")));
		var right = roundHalf(parseFloat(selectedContact.style.right.replace("vw", "")));
		google.maps.event.trigger(map, 'resize');
		if((width == 80 && right == 0) || windowType != 3) {
			clearInterval(myInterval);
		}
		
		if(width < 80 && windowType==3) {
			mapDiv.style.width = roundHalf(width+0.5)+ "vw";
		} else if(width > 80 && windowType==3) {
			mapDiv.style.width = roundHalf(width-0.5)+ "vw";
		}
		
		if(right < 0 && windowType==3) {
			selectedContact.style.right = roundHalf(right+0.5)+"vw";
		} else if(right > 0 && windowType==3) {
			selectedContact.style.right = roundHalf(right-0.5)+"vw";
		}
	}, 1);
}

function settingsToggle() {
	var upDownElm = document.getElementById("settingsUpDown");
	var toggled = upDownElm.getAttribute("value");
	if(toggled == "true" || toggled == "false") {
		var settingsItems = document.getElementsByClassName("settingsItem");
		toggleItems = [];
		
		for(var i = 0; i < settingsItems.length; i++) {
			if(settingsItems[i].hasAttribute("num")) {
				var val = parseInt(settingsItems[i].getAttribute("num"));
				toggleItems[val] = settingsItems[i];
			}
		}
		if(toggled == "true") {
			toggleItems.reverse();
			upDownElm.setAttribute("value", "mvup");
			upDownElm.innerHTML = "&#9660;";
		} else if(toggled == "false") {
			upDownElm.setAttribute("value", "mvdown");
			upDownElm.innerHTML = "&#9650;";
		}
		toggled = upDownElm.getAttribute("value");
	}
	
	
	if(toggled == "mvdown") {
		indexItem++;
		while(indexItem < toggleItems.length && toggleItems[indexItem] === undefined) { indexItem++;}
		if(indexItem < toggleItems.length) {
				addPaddingInterval = setInterval(addPadding, 1);
		} else {
			indexItem = -1;
			upDownElm.setAttribute("value", "true");
		}
	} else if (toggled == "mvup") {
		indexItem++;
		while(indexItem < toggleItems.length && toggleItems[indexItem] === undefined) { indexItem++;}
		if(indexItem < toggleItems.length) {
				removePaddingInterval = setInterval(removePadding, 1);
		} else {
			indexItem = -1;
			upDownElm.setAttribute("value", "false");
		}
	}
}

function addPadding() {
	var padding = roundHalf(parseFloat(toggleItems[indexItem].style.paddingBottom.replace("px","")));
	if(padding == 10) {
		clearInterval(addPaddingInterval);
		addHeightInterval = setInterval(addHeight, 1);
	}
	
	if(padding > 10) {
		toggleItems[indexItem].style.paddingBottom = roundHalf(padding-0.5)+"px";
	} else if( padding < 10) {
		toggleItems[indexItem].style.paddingBottom = roundHalf(padding+0.5)+"px";
	}
}

function addHeight() {
	var height = roundHalf(parseFloat(toggleItems[indexItem].style.height.replace("px","")));
	if(height == 20) {
		clearInterval(addHeightInterval);
		settingsToggle();
	}
	
	if(height > 20) {
		toggleItems[indexItem].style.height = roundHalf(height-0.5)+"px";
	} else if(height < 20) {
		toggleItems[indexItem].style.height = roundHalf(height+0.5)+"px";
	}
}

function removePadding() {
	var padding = roundHalf(parseFloat(toggleItems[indexItem].style.paddingBottom.replace("px","")));
	if(padding == 0) {
		clearInterval(removePaddingInterval);
		removeHeightInterval = setInterval(removeHeight, 1);
	}
	
	if(padding > 0) {
		toggleItems[indexItem].style.paddingBottom = roundHalf(padding-0.5)+"px";
	} else if( padding < 0) {
		toggleItems[indexItem].style.paddingBottom = roundHalf(padding+0.5)+"px";
	}
}

function removeHeight() {
	var height = roundHalf(parseFloat(toggleItems[indexItem].style.height.replace("px","")));
	if(height == 0) {
		clearInterval(removeHeightInterval);
		settingsToggle();
	}
	
	if(height > 0) {
		toggleItems[indexItem].style.height = roundHalf(height-0.5)+"px";
	} else if(height < 0) {
		toggleItems[indexItem].style.height = roundHalf(height+0.5)+"px";
	}
}

window.addEventListener('load',function loadPanels() {
	mapDiv = document.getElementById('mapDiv');
	selectedContact = document.getElementById('selectedContact');
	selectedContact.style.position = 'fixed';
	
	window.scrollTo(0,0);
});

var mapDiv, selectedContact;
var windowType = 0;
			
var addPaddingInterval, addHeightInterval;
var removePaddingInterval, removeHeightInterval;
var toggleItems;
var indexItem = -1;