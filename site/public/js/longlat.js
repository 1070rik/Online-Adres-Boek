function returnOrUndefined(txt, extra, prefix) {
	if (extra === undefined) {
		extra = "";
	}
	if (prefix === undefined) {
		prefix = "";
	}
	if (txt !== undefined) {
		return prefix + txt + extra;
	} else {
		return "";
	}
}

//Make the AJAX request and place all the markers if map loaded
function getLongLang(filter) {
	if (filter === undefined) {
		filter = {};
	}
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function () {
		if (this.readyState == 4 && this.status == 200) {
			var placeData = JSON.parse(this.response);
			longLangCallback(placeData.results[0].geometry.location);
		}
	};
	var requestUrl = "https://maps.googleapis.com/maps/api/geocode/json?address=";

	var searchPlace = returnOrUndefined(filter.straatnaam).replace(" ", "+");
	searchPlace += returnOrUndefined(filter.huisnummer).replace(" ", "+");
	searchPlace += returnOrUndefined(filter.plaats).replace(" ", "+");
	searchPlace += returnOrUndefined(filter.postcode).replace(" ", "+");

	if (searchPlace.length > 0) {
		requestUrl += searchPlace + "&key=AIzaSyDKZlYb-j15azWaz3lQxTcEzYE7P43S3kU";

		xhttp.open("POST", requestUrl, true);
		xhttp.send();
		return true;
	} else {
		return false;
	}
}