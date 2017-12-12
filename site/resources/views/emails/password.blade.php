@extends('layouts.email_head')


@section('content')
<h1>Welcome {{ $data['email'] }}</h1>
<p>Your login information is:</p>
<pre>
  email: {{ $data['email'] }}
  password {{ $data['password'] }}
</pre>
<p>We advice you to change your password immedietly after login. This can be done in the account settings.</p>

<a href="{{ url('/') }}"></a><button type="button" name="button" class="btn btn-primary">Login</button><br>
<a href="{{ url('/') }}"><small>If the button doesn't work please press this link.</small></a>
@endsection
