@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            @if(session('message_negative'))
            <div class="alert alert-danger">
              <strong>Error!</strong> {{ session('message_negative') }}
            </div>
            @elseif(session('message_positive'))
            <div class="alert alert-success">
              <strong>Success!</strong> {{ session('message_positive') }}
            </div>
            @endif
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    You are logged in!
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
