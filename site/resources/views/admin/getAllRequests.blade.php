@extends('layouts.admin')

@section('content')
<div class="container">
    @if(session('error'))
        <div class="alert alert-danger">
            <strong>Error!</strong> {{ session('error') }}
        </div>
    @endif

    <div class="pageHeader">
        <div class="headerLeft">
          <h1 class="pageTitle">Requests</h1>
        </div>
        <div class="headerRight">
        </div>
    </div>
    @if(session('message-negative'))
    <div class="alert alert-danger">
        {{ session('message-negative') }}
    </div>
    @elseif(session('message-positive'))
        <div class="alert alert-success">
            {{ session('message-positive')}}
        </div>
    @endif
    <div class="table">

        <div class="tr">
            <span class="td col-md-2">ID</span>
            <span class="td col-md-6">Email</span>
        </div>

        @foreach($requests as $request)

        <form class="tr form-horizontal" method="POST" action="{{ route('editRequestPost') }}">
            {{ csrf_field() }}
            <span class="td col-md-2">
                <input for="id" type="text" name="id" class="form-control" name="id" value="{{$request->id}}" readonly />
            </span>
            <span class="td col-md-6">
                <input for="email" type="email" name="email" class="form-control" name="email" value="{{$request->email}}" required />
            </span>
            <span class="td col-md-2">
                <div class="form-group">
                    <button type="submit" class="btn btn-primary" style="width: 90%;" name="submit" value="approve">Approve</button>
                </div>
            </span>
            <span class="td col-md-2">
                <div class="form-group">
                    <button type="submit" class="btn btn-primary" style="width: 90%;" name="submit" value="delete">Verwijder</button>
                </div>
            </span>
        </form>
        @endforeach

    </div>
</div>
      
@endsection
