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

function MarkerObj(Adres, Contacts) {
	this.adres = Adres;
	//Makes sure contacts is an Array
	if (Contacts.constructor.name == "Contact") {
		Contacts = [Contacts];
	}

	//Creates dot if it must have a dot
	this.contacts = Contacts;
	if (Contacts.length > 1) {
		this.hasDot = false;
	} else {
		this.hasDot = true;
	}

	//Create the content for the infowindow
	this.content = "";
	for (var i = 0; i < this.contacts.length; i++) {
		this.content += " <div id=\"infowindow\"><h3>";
		this.content += returnOrUndefined(this.contacts[i].voornaam, " ");
		this.content += returnOrUndefined(this.contacts[i].tussenvoegsel, " ");
		this.content += returnOrUndefined(this.contacts[i].achternaam);
		this.content += "</h3><hr>";
		this.content += returnOrUndefined(this.adres.straatnaam, " ");
		this.content += returnOrUndefined(this.adres.huisnummer);
		this.content += "<br>";
		this.content += returnOrUndefined(this.adres.postcode, " ");
		this.content += returnOrUndefined(this.adres.plaats);
		this.content += "</div>";
		if (i < this.contacts.length - 1) {
			this.content += "<br>";
		}
	}

	//Function to add the marker to google maps
	this.addMarker = function () {
		var length = this.contacts.length;
		if (length <= 1) {
			length = "";
		}
		this.marker = new google.maps.Marker({
			position: { lat: parseFloat(this.adres.latitude), lng: parseFloat(this.adres.longitude) },
			title: "lat: " + this.adres.latitude + " lng: " + this.adres.longitude,
			map: map,
			optimized: false,
			label: "" + length,
			markerObj: this,
			icon: getMarkerImg("#F00", this.hasDot)
		});
	};
}

function getMarkerImg(color, dot) {
	if (color === undefined) {
		color = "#F00";
	}
	if (dot === undefined) {
		dot = true;
	}
	color = color.replace("#", "%23");
	var markerImg = {
		url: "imgs/mapsMarker.php?color=" + color + "&dot=" + dot,
		scaledSize: new google.maps.Size(22, 34),
		labelOrigin: new google.maps.Point(11, 11)
	};
	return markerImg;
}

function createMarkerObjs(adrAndCon) {
	var markerObjs = [];
	for (var i = 0; i < adrAndCon.addresses.length; i++) {
		var address = adrAndCon.addresses[i];
		var addressContacts = adrAndCon.contacts.filter(function (obj) {
			return obj.adresID == address.id;
		});
		markerObjs.push(new MarkerObj(address, addressContacts));
	}
	return markerObjs;
}

function placeMarkers() {
	notPlacedMarkers = false;
	markerObjs = createMarkerObjs(allData);
	infowindow = new google.maps.InfoWindow({
		pixelOffset: new google.maps.Size(-1.5, 10)
	});

	var markersArr = [];

	var _loop = function _loop(i) {
		var markerObj = markerObjs[i];
		var adres = markerObj.adres;
		var contacts = markerObj.contacts;
		markerObj.addMarker();
		var marker = markerObjs[i].marker;
		marker.addListener('');

		marker.addListener('click', function () {
			map.panTo(marker.getPosition());
			if (infowindow.markerObj !== undefined && infowindow.markerObj.marker != marker) {
				infowindow.markerObj.marker.setIcon(getMarkerImg("#F00", infowindow.markerObj.hasDot));
			}
			marker.setIcon(getMarkerImg("#0F0", markerObj.hasDot));
			infowindow.setContent(markerObj.content);
			infowindow.pixelOffset.height = 10;
			infowindow.open(map, marker);
			infowindow.markerObj = markerObj;
		});

		marker.addListener('mouseover', function () {
			if (infowindow.markerObj == undefined || infowindow.markerObj.marker != marker) {
				marker.setIcon(getMarkerImg("#F66", markerObj.hasDot));
			} else {
				marker.setIcon(getMarkerImg("#6F6", markerObj.hasDot));
			}
		});

		marker.addListener('mouseout', function () {
			if (infowindow.markerObj == undefined || infowindow.markerObj.marker != marker) {
				marker.setIcon(getMarkerImg("#F00", markerObj.hasDot));
			} else {
				marker.setIcon(getMarkerImg("#0F0", markerObj.hasDot));
			}
		});

		markersArr.push(marker);
	};


	for (var i = 0; i < markerObjs.length; i++) {
		_loop(i);
	}
	var markerCluster = new MarkerClusterer(map, markersArr,
            {imagePath: 'imgs/mapsMarker.php'});
}

function removeMarkers() {
	for (var i = 0; i < markerObjs.length; i++) {
		markerObjs[i].marker.setMap(null);
	}
	markerObjs = [];
	notPlacedMarkers = true;
}

//Make the AJAX request and place all the markers if map loaded
function placeAllMarkers(filter) {
	if (markerObjs.length > 0) {
		removeMarkers();
	}
	if (filter === undefined) {
		filter = {};
	}
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function () {
		if (this.readyState == 4 && this.status == 200) {
			allData = JSON.parse(this.response);
			if (notPlacedMarkers && !googleMapNotLoaded) {
				placeMarkers();
			}
		}
	};
	var requestUrl = "bla?api=1";
	requestUrl += returnOrUndefined(filter.voornaam, "", "&voornaam=");
	requestUrl += returnOrUndefined(filter.achternaam, "", "&achternaam=");
	requestUrl += returnOrUndefined(filter.straatnaam, "", "&straatnaam=");
	requestUrl += returnOrUndefined(filter.huisnummer, "", "&huisnummer=");
	requestUrl += returnOrUndefined(filter.plaats, "", "&plaats=");
	requestUrl += returnOrUndefined(filter.postcode, "", "&postcode=");

	xhttp.open("POST", requestUrl, true);
	xhttp.send();
}

function initMap() {
	//Nederland,Amersfoort 52.1589302,5.3077833
	var coord = { lat: 52.1589302, lng: 5.3077833 };

	//Initiliaze map
	map = new google.maps.Map(document.getElementById('map'), {
		zoom: 8,
		center: coord,
		mapTypeId: 'roadmap',
		zoomControl: true,
		mapTypeControl: false,
		scaleControl: false,
		streetViewControl: false,
		rotateControl: false,
		fullscreenControl: false,
		disableDefaultUI: false,
		animation: google.maps.Animation.DROP,
		styles: [{
			"featureType": "poi.business",
			"stylers": [{
				"visibility": "off"
			}]
		}, {
			"featureType": "road",
			"elementType": "labels.icon",
			"stylers": [{
				"visibility": "off"
			}]
		}, {
			"featureType": "transit",
			"stylers": [{
				"visibility": "off"
			}]
		}]
	});

    map.setOptions({draggable: false, zoomControl: false, scrollWheel: false, disableDoubleClick: true})

	//Set variable so it is loaded and add markers if not already added
	googleMapNotLoaded = false;
	if (allData.hasOwnProperty("contacts") && allData.hasOwnProperty("addresses") && notPlacedMarkers) {
		placeMarkers();
	}
}

function disablePanningAndScrolling() {
	map.setOptions({
		zoomControl: false,
		gestureHandling: 'none'
	});
}

var notPlacedMarkers = true;
var googleMapNotLoaded = true;
var allData = {};
var markerObjs = [];
var map;
var infowindow;
