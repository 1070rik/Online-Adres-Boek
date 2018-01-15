<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
	    <meta name="mobile-web-app-capable" content="yes">

        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
        <link rel="stylesheet" href="{{ asset('css/app_maps.css') }}">
        <!-- <link rel="stylesheet" href="{{ asset('css/app_map_phone.css') }}"> -->
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.bundle.min.js" integrity="sha384-3ziFidFTgxJXHMDttyPJKDuTlmxJlwbSkojudK/CkRqKDOmeSbN6KLrGdrBQnT2n" crossorigin="anonymous"></script>
        <style>
        </style>
        <!--IMPORTANT-->
        <script src="js/maps.js?v=<?=time()?>"></script>
        <!-- TESTING DINGIES -->
        <script>
            // placeAllMarkers() will place all markers without a
            placeAllMarkers();

            function runSearch(e) {
                if (e.keyCode == 13) {
                    searchContact();
                }
            }



            function searchContact() {
                var filter = {
                    voornaam: $("#InputVoornaam").val(),
                    tussenvoegsel: $("#InputTussenvoegsel").val(),
                    achternaam: $("#InputAchternaam").val(),
                    adres: $("#InputAdres").val(),
                    plaats: $("#InputPlaats").val(),
                    postcode: $("#InputPostcode").val(),
                }
                if(document.getElementById('filtrerenradios1').checked) {
                    filter['filter'] = 'asc';
                }else if(document.getElementById('filtrerenradios2').checked) {
                    filter['filter'] = 'desc';
                }

                if(document.getElementById('exampleRadios1').checked) {
                    filter['sort'] = 'contacts.voornaam';
                }else if(document.getElementById('exampleRadios2').checked){
                    filter['sort'] = 'contacts.achternaam';
                }else if(document.getElementById('exampleRadios3').checked){
                    filter['sort'] = 'addresses.straatnaam';
                }else if(document.getElementById('exampleRadios4').checked){
                    filter['sort'] = 'addresses.plaats';
                }
                console.log(filter);
                placeAllMarkers(filter);
            };
            function longLangCallback(e) {
                console.log(e);
            }
			
            function setScreenSize() {
			//setInterval(function() {document.body.clientHeight = window.innerHeight+"px";}, 500);
			document.body.clientHeight = window.innerHeight+"px";
            }
        </script>
        <!---->
    </head>
    <body>
        @yield('content')
        <script src="{{ asset('js/panelsCSS.js') }}?v=<?=time()?>"></script>
        <script src="{{ asset('js/markerclusterer.js') }}?v=<?=time()?>"></script>
        <script async defer
            src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDKZlYb-j15azWaz3lQxTcEzYE7P43S3kU&callback=initMap"></script>
        <!---->
        
    </body>
    <script>
		setScreenSize();
	</script>
</html>
