@extends('layouts.maps_head')

@section('content')
<!--IMPORTANT-->
<div id="container">
    <div id="mapDiv">
        <div id="map"></div>
        <div id="search">
            <div class="searchPanel">
                <div class="form-group search-form">
                    <input type="text" class="form-control zoekfunctiebar mainBar" id="InputVoornaam" placeholder="Zoeken op voornaam..." onkeypress="return runSearch(event)">
                    <a class="laatmaarhiden zoekfunctiebutton" onclick="searchContact()"><img src="imgs/search_icon.png" alt="Search icon"></a>
                    <span class="clear"></span>
                </div>
                <div id="panel">
                    <div class="form-group">
                        <h3>Filteren</h3>
                        <input type="text" class="form-control zoekfunctiebar" id="InputTussenvoegsel" aria-describedby="emailHelp" placeholder="Tussenvoegsel">
                        <input type="text" class="form-control zoekfunctiebar" id="InputAchternaam" aria-describedby="emailHelp" placeholder="Achternaam">
                        <input type="text" class="form-control zoekfunctiebar" id="InputAdres" aria-describedby="emailHelp" placeholder="Adres">
                        <input type="text" class="form-control zoekfunctiebar" id="InputPlaats" aria-describedby="emailHelp" placeholder="Plaats">
                        <input type="text" class="form-control zoekfunctiebar" id="InputPostcode" aria-describedby="emailHelp" placeholder="Postcode">
                        <h3>Sorteren</h3>
                    </div>
                    <div class="form-check radio-inline1">
                        <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios1" value="option1" checked>
                        Voornaam
                        </label>
                    </div>
                    <div class="form-check radio-inline2">
                        <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios2" value="option2">
                        Achternaam
                        </label>
                    </div>
                    <br>
                    <div class="form-check radio-inline1">
                        <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios1" value="option3">
                        Adres
                        </label>
                    </div>
                    <div class="form-check radio-inline3">
                        <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios2" value="option4">
                        Plaats
                        </label>
                    </div>
                    <h3>Filtreren</h3>
                    <div class="form-check radio-inline1">
                        <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="filtrerenradios" id="filtrerenradios1" value="option1" checked>
                        Oplopend
                        </label>
                    </div>
                    <div class="form-check radio-inline2">
                        <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="filtrerenradios" id="filtrerenradios2" value="option2">
                        Aflopend
                        </label>
                    </div>
                </div>
            </div>
            <div id="flip"><b class="arrow">&#8964;</b></div>
        </div>
        <div id="settings">
            <div id="mijngegevens">
                <p>{{Auth::user()->email}}<a href="#"><img src="imgs/user.png" class="loginpicture" alt="profile pic" onclick="getSelectedById({{Auth::user()->id}})"></a></p>
            </div>
            <div id="settingsMore">
                @if(Auth::user()->admin == 1)
                <a href="{{ route('adminIndex') }}" target="_blank">
                    <p>Admin panel</p>
                </a>
                @endif
                <a href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                    <p>Uitloggen</p>
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    {{ csrf_field() }}
                </form>
            </div>
        </div>
    </div><!--

    --><div id="allContacts" class="scrollbar">
        <div class="topbar">
            <a class="close-icon-parent" onclick="hideAllContacts()"><i class="material-icons close-icon">&#xE5CD;</i></a>
        </div>
		<div id="contactsList"></div>
    </div><!--

    --><div id="selectedContact">
        <div class="darktopbar">
            <a class="close-icon-parent" onclick="hideSelectedContact()"><i class="material-icons close-icon">&#xE5CD;</i></a>
        </div>
        <!-- User info -->
		<div id="userInfo">
		</div>
    </div>
</div>
@endsection
