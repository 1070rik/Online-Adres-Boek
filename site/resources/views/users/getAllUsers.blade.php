@extends('layouts.app')

@section('content')
<div class="container">  
	@if(session('error'))
    <div class="alert alert-danger">
        <strong>Error!</strong> {{ session('error') }}
    </div>
    @endif
	<div class="table">

		<div class="tr">
			<span class="td col-md-1">ID</span>
			<span class="td col-md-6">Email</span>
			<span class="td col-md-1">Admin</span>
		</div>

		@foreach($users as $user)
		
	    <form class="tr form-horizontal" method="POST" action="{{ route('editUserPost') }}">
			{{ csrf_field() }}      
            <span class="td col-md-1">
            	<input for="id" type="text" name="id" class="form-control" name="id" value="{{$user->id}}" readonly />
            </span>
            <span class="td col-md-6">
            	<input for="email" type="email" name="email" class="form-control" name="email" value="{{$user->email}}" required />
            </span>
            <span class="td col-md-2">
            	<select  for="admin" class="form-control" name="admin" required>
            		@if ($user->admin == 0)
	        			<option value="0" selected>Nee</option>
	        			<option value="1">Ja</option>
	        		@else
	        			<option value="0">Nee</option>
	        			<option value="1" selected>Ja</option>
	        		@endif
	        	</select>
            </span>
			<span class="td col-md-1">
                <div class="form-group">
			        <button type="submit" class="btn btn-primary" name="submit" value="change">Verander</button>
				</div>
			</span>
			<span class="td col-md-1">
                <div class="form-group">
			        <button type="submit" class="btn btn-primary" name="submit" value="delete">Verwijder</button>
				</div>
			</span>
    	</form>
    	@endforeach  

    	<form class="form-horizontal" method="GET" action="{{ route('createUser') }}">
    		<input class="btn btn-primary" type="submit" value="Nieuw" />
    	</form>

    </div>
</div>
@endsection
