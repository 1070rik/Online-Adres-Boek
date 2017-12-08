@extends('layouts.app')

@section('content')
<div class="container">
	<table class="table">

		<tr class="row">
			<th class="col-md-1">ID</th>
			<th class="col-md-1">Email</th>
			<th class="col-md-1">Admin</th>
		</tr>

		@foreach($users as $user)
        <tr class="row">        
                <td class="col-md-1">{{$user->id}}</td>
                <td class="col-md-1">{{$user->email}}</td>
                <td class="col-md-1">{{$user->admin}}</td>
    	</tr>
    	@endforeach  
    	
    </table>
</div>
@endsection
