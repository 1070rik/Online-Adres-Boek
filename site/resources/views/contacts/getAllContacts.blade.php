@extends('layouts.app')

@section('content')

@if(session('error'))
    <div class="alert alert-danger">
        <strong>Error!</strong> {{ session('error') }}
    </div>
@endif
    <div class="row">
        <div class="col-md-6 col-md-offset-3">

            <!-- <table class="table">
                <thead>
                    <th>ID</th>
                    <th>Voornaam</th>
                    <th>tussenvoegsel</th>
                    <th>Achternaam</th>
                    <th>Geboortedatum</th>
                    <th>telefoonnummer</th>
                    <th>email</th>
                    <th>fotoPad</th>
                    <th>beschrijving</th>
                </thead>
                <tbody>

                </tbody>
            </table>
 -->
             <div class="tr">
                 <span class="td col-md-1">ID</span>
                 <span class="td col-md-1">Voornaam</span>
                 <span class="td col-md-1">tussenvoegsel</span>
                 <span class="td col-md-2">Achternaam</span>
                 <span class="td col-md-1">Geboortedatum</span>
                 <span class="td col-md-1">Telefoonnummer</span>
                 <span class="td col-md-1">Email</span>
                 <span class="td col-md-1">fotoPad</span>
                 <span class="td col-md-1">Beschrijving</span>
             </div>
            @foreach($contacts as $contact)
                <form class="tr form-horizontal" method="POST" action="{{ route('editContactPost') }}">
                    {{ csrf_field() }}
                    <span class="td col-md-1">
                        <input for="id" type="text" name="id" class="form-control" name="id" value="{{$contact->id}}" readonly />
                    </span>
                    <span class="td col-md-1">
                        <input for="voornaam" type="text" name="voornaam" class="form-control" value="{{$contact->voornaam}}" required />
                    </span>
                    <span class="td col-md-1">
                        <input for="tussenvoegsel" type="text" name="tussenvoegsel" class="form-control" value="{{$contact->tussenvoegsel}}" />
                    </span>
                    <span class="td col-md-2">
                        <input for="achternaam" type="text" name="achternaam" class="form-control" value="{{$contact->achternaam}}" required />
                    </span>
                    <span class="td col-md-1">
                        <input for="geboortedatum" type="text" name="geboortedatum" class="form-control" value="{{$contact->geboortedatum}}" required />
                    </span>
                    <span class="td col-md-1">
                        <input for="telefoonnummer" type="tel" name="telefoonnummer" class="form-control" value="{{$contact->telefoonnummer}}" required />
                    </span>
                    <span class="td col-md-1">
                        <input for="email" type="email" name="email" class="form-control" value="{{$contact->email}}" required />
                    </span>
                    <span class="td col-md-1">
                        <input for="foto" type="text" name="fotoPad" class="form-control" value="{{$contact->fotoPad}}" required />
                    </span>
                    <span class="td col-md-1">
                        <input for="beschrijving" type="text" name="beschrijving" class="form-control" value="{{$contact->beschrijving}}" required />
                    </span>
                    <span class="td col-md-1">
                        <div class="form-group">
                            <input type="submit" value="Edit" class="btn btn-primary" name="edit">
                            </input>
                        </div>
                    </span>
                    <span class="td col-md-1">
                        <div class="form-group">
                            <input type="submit" value="Delete" class="btn btn-primary" name="delete">
                            </input>
                        </div>
                    </span>
                </form>
            @endforeach

        </div>
    </div>
@endsection
