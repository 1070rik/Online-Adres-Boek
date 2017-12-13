@extends('layouts.app')
@section('content')
<form class="form-horizontal" method="POST" action="{{ route('addUserPost') }}">
    {{ csrf_field() }}

    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
        <label for="email" class="col-md-4 control-label">E-Mail Address</label>

        <div class="col-md-6">
            <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>

            @if ($errors->has('email'))
                <span class="help-block">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
            @endif
        </div>
    </div>

	<div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
        <label for="admin" class="col-md-4 control-label">Is admin</label>

        <div class="col-md-6">
        	<select  for="admin" class="form-control" name="admin" required>
        		<option value="0">Nee</option>
        		<option value="1">Ja</option>
        	</select>
        </div>
    </div>

	<div class="form-group">
    	<div class="col-md-8 col-md-offset-4">
	        <button type="submit" class="btn btn-primary">
	            Voeg gebruiker toe
	        </button>
	    </div>
	</div>
</form>
@endsection
