<!doctype html>
<html lang="en">

<head>
  <title>Hello, world!</title>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
  <style>
    #wrapper
    {
      position: relative;
    }

    #zoekbar
    {
      position: absolute;
      top: 10px;
      left: 10px;
      z-index: 99;
      background-color: white;
      width: 350px;
      height: auto;
      display: inline-block;
      padding: 0px;
    }

    div.row:nth-child(2)>div:nth-child(1) {
      padding: 0px !important;
    }

    div.row:nth-child(2) {
      margin: 0px !important;
    }

    html body div#wrapper div.row {
      margin: 0px !important;
    }

    #map
    {
      position: relative;
    }

    #dropdown_zoekbar {
      background-color: gray;
      display: inline-block;
      text-align: center;
    }

    #panel,
    #flip {
      text-align: center;
      background-color: white;
    }

    #panel {
      display: none;
    }

    #rightpanel {
      width: 80%;
      position: absolute;
      z-index: 100;
      background-color: red;
      right: 0px;
      height: 949px;
    }

    #inhoudrechtsepaneel {
      width: 100%;
    }

    .laatmaarhiden {
      display: none;
    }

    .card-img-left {
      border-bottom-left-radius: calc(.25rem - 1px);
      border-top-left-radius: calc(.25rem - 1px);
      float: left;
      padding-right: 1em;
      margin-bottom: -1.25em;
      background-color: blue;
      width: 100px;
      height: 100px;
    }
  </style>
  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js" integrity="sha256-T0Vest3yCU7pafRw9r+settMBX6JkKN06dqBnpQ8d30=" crossorigin="anonymous">
  </script>
  <script>
    $(document).ready(function() {


      $("#flip").click(function() {
        $("#panel").slideToggle("slow");
      });
    });

    $(document).ready(function() {

      $("#rightpanel").hide();
      $(".laatmaarhiden").show();

      $('.laatmaarhiden').click(function() {
        $("#rightpanel").toggle("slide", {
          direction: 'right'
        });
      });

    });
  </script>
</head>

<body>
  <div id="wrapper">
    <div class="row">
      <div class="col-9"></div>
      <div class="col-3">
        <div id="rightpanel">
          <div id="inhoudrechtsepaneel">
            <div class="card">
              <div class="row">
                <div class="col-4">
                  <div class="card-img-left">
                  </div>
                </div>
                <div class="col-8">
                  <div class="card-block">
                    <h5 class="card-title">Piet, Jansen</h5>
                    <p class="card-text">Pietjeslaan 12</p>
                    <p class="card-text">Doetinchem, 2020 AD</p>
                    <!--<a href="#" class="btn btn-primary">Read More</a>-->
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-12">
        <div id="map"></div>
        <script>
          function initMap() {
            var uluru = {
              lat: -25.363,
              lng: 131.044
            };
            var map = new google.maps.Map(document.getElementById('map'), {
              zoom: 4,
              center: uluru
            });
            var marker = new google.maps.Marker({
              position: uluru,
              map: map
            });
          }
        </script>
        <script async defer src="https://maps.googleapis.com/maps/api/js?key= AIzaSyDAlYShGvgROQ1TzDY0jfumV1ab9nMoJI8 &callback=initMap">
        </script>
      </div>
    </div>
    <div id="zoekbar">
      <div class="row">
        <div class="col-12">
          <form>
            <div class="form-group">
              <input type="text" class="form-control" id="InputVoornaam" aria-describedby="emailHelp" placeholder="Zoeken op voornaam...">
            </div>
            <div class="col-12">
              <div id="panel">
                <div class="form-group">
                  <input type="text" class="form-control" id="InputTussenvoegsel" aria-describedby="emailHelp" placeholder="Tussenvoegsel">
                  <input type="text" class="form-control" id="InputAchternaam" aria-describedby="emailHelp" placeholder="Achternaam">
                  <input type="text" class="form-control" id="InputAdres" aria-describedby="emailHelp" placeholder="Adres">
                  <input type="text" class="form-control" id="InputPlaats" aria-describedby="emailHelp" placeholder="Plaats">
                  <input type="text" class="form-control" id="InputPostcode" aria-describedby="emailHelp" placeholder="Postcode">
                  <button class="laatmaarhiden" type="button" name="button">ZOEK</button>
                </div>
              </div>
              <div id="flip">Meer zoek functies</div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- Optional JavaScript -->
  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
</body>

</html>
