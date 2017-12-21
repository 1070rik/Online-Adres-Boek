@extends('layouts.maps_head')

@section('content')
<!--IMPORTANT-->
<div id="container">
    <div id="mapDiv">
        <div id="map"></div>
        <div id="search">
            <div class="searchPanel">
                <div class="form-group search-form">
                    <input type="email" class="form-control zoekfunctiebar mainBar" id="InputVoornaam" placeholder="Zoeken op voornaam...">
                    <a class="laatmaarhiden zoekfunctiebutton" onclick="searchContact()"><img src="imgs/search_icon.png" alt="Search icon"></a>
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
                        <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios1" value="option1" checked>
                        Adres
                        </label>
                    </div>
                    <div class="form-check radio-inline3">
                        <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios2" value="option2">
                        Plaats
                        </label>
                    </div>
                </div>
            </div>
            <div id="flip"><b class="arrow">&#8964;</b></div>
        </div>
        <div id="settings">
            <div id="mijngegevens">
                <p>{{Auth::user()->email}}<a href="#"><img src="imgs/user.png" class="loginpicture" alt="profile pic" onclick="showContact('own', {{Auth::user()}})"></a></p>
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
            <a class="close-icon-parent" onclick="hideAll()"><i class="material-icons close-icon">&#xE5CD;</i></a>
        </div>
        <a onclick="showAll()">
            <div class="card">
                <div class="row">
                    <div class="col-md-2">
                        <div class="cardImage"><img src="imgs/user.png"></div>
                    </div>
                    <div class="col-md-10">
                        <div class="cardText">
                            <h4 class="card-naam">Foo van der bar</h4>
                            <p class="card-address">Pietjeslaan 69</p>
                            <p>Doetinchem lmao</p>
                        </div>
                    </div>
                </div>
            </div>
        </a>
        <a onclick="showAll()">
            <div class="card">
                <div class="row">
                    <div class="col-md-2">
                        <div class="cardImage"><img src="imgs/user.png"></div>
                    </div>
                    <div class="col-md-10">
                        <div class="cardText">
                            <h4 class="card-naam">Foo van der bar</h4>
                            <p class="card-address">Pietjeslaan 69</p>
                            <p>Doetinchem lmao</p>
                        </div>
                    </div>
                </div>
            </div>
        </a>
        <a onclick="showAll()">
            <div class="card">
                <div class="row">
                    <div class="col-md-2">
                        <div class="cardImage"><img src="imgs/user.png"></div>
                    </div>
                    <div class="col-md-10">
                        <div class="cardText">
                            <h4 class="card-naam">Foo van der bar</h4>
                            <p class="card-address">Pietjeslaan 69</p>
                            <p>Doetinchem lmao</p>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    </div><!--
	
    --><div id="selectedContact">
        <div class="topbar">
            <a class="close-icon-parent" onclick="hideAll()"><i class="material-icons close-icon">&#xE5CD;</i></a>
        </div>
        <!-- User info -->
        <img src="{{ asset('imgs/user.png') }}" class="profile-pic"/>
        <p class="name"></p>
        <div class="user-extra">
             
        </div>
    </div>
</div>
@endsection