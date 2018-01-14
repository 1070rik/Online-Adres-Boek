@extends('layouts.login_head')

@section('content')
<div class="container">
    <div id="map"></div>
    <div class="login-container">
        <div class="login col-md-3 col-xs-8">
          <div class="row">
            <div class="login-title col-xs-12">
              <!-- <h3>{{ config('app.name', 'Adres Boek') }}</h3> -->
              <img src="https://memestatic3.fjcdn.com/comments/Join+list+_2b1fb48682de4241b304bdd0cb3ce4d8.jpg" class="login-image">
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
              <form method="POST" action="{{ route('login') }}">
                  {{ csrf_field() }}
                <div class="form-group">
                  <div class="input-group">
                        <div class="input-group-addon"><i class="fa fa-envelope" aria-hidden="true"></i></div>
                    <input type="email" class="form-control" name="email" id="email" placeholder="Email">
                  </div>
                  @if ($errors->has('email'))
                      <span class="help-block">
                          <strong>{{ $errors->first('email') }}</strong>
                      </span>
                  @endif
                </div>
                <div class="form-group">
                  <div class="input-group">
                    <div class="input-group-addon"><i class="fa fa-key" aria-hidden="true"></i></span></div>
                    <input type="password" class="form-control" name="password" id="password" placeholder="Password">
                  </div>
                  @if ($errors->has('password'))
                      <span class="help-block">
                          <strong>{{ $errors->first('password') }}</strong>
                      </span>
                  @endif
                </div>
                <div class="form-group text-center">
                  <input type="submit" class="btn btn-primary btn-block" type="button" name="button" value="Login"/>
                </div>
              </form>
            </div>
            <div class="login-footer col-xs-12">
              <a href="{{ route('password.request') }}" class="text-muted pull-left">Forgot Password?</a>
              <a href="{{ route('requestUser') }}" class="text-muted pull-right">Request account</a>
            </div>
          </div>
        </div>
    </div>
</div>
@endsection
