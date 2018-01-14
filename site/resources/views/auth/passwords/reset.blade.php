@extends('layouts.login_head')

@section('content')
<div class="container">
    <div id="map"></div>
    <div class="login-container">
        <div class="login col-md-3 col-xs-8">
          <div class="row">
            <div class="login-title col-xs-12">
              <h3>Password reset</h3>
            </div>
            <div class="login-content col-xs-12">
              @if(session('message-negative'))
              <div class="alert alert-danger">
                  {{ session('message-negative') }}
              </div>
              @elseif(session('message-positive'))
              <div class="alert alert-success">
                  {{ session('message-positive')}}
              </div>
              @endif
              <form method="POST" action="{{ route('passwordResetPost') }}">
                {{ csrf_field() }}
                <input type="hidden" name="reset_token" value="{{ $token }}">
                <div class="form-group">
                  <div class="input-group">
                    <div class="input-group-addon"><i class="fa fa-envelope" aria-hidden="true"></i></div>
                    <input type="email" class="form-control" name="email" id="email" placeholder="Uw Email">
                  </div>
                  <div class="input-group">
                        <div class="input-group-addon"><i class="fa fa-lock" aria-hidden="true"></i></div>
                    <input type="password" class="form-control" name="password" id="password" placeholder="Nieuw wachtwoord">
                  </div>
                  <div class="input-group">
                        <div class="input-group-addon"><i class="fa fa-lock" aria-hidden="true"></i></div>
                    <input type="password" class="form-control" name="password_repeat" id="password" placeholder="Nieuw wachtwoord opnieuw">
                  </div>
                </div>
                <div class="form-group text-center">
                  <input type="submit" class="btn btn-primary btn-block" type="button" name="button" value="Vraag aan"/>
                </div>
              </form>
            </div>
            <div class="login-footer col-xs-12">
              <a href="{{ route('login') }}" class="text-muted pull-left">Terug naar login</a>
            </div>
          </div>
        </div>
    </div>
</div>
@endsection
