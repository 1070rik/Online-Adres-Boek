@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Reset password</div>

                <div class="panel-body">
                    <form class="form-horizontal" method="POST" action="{{ route('resetFirstPasswordPost') }}">
                        {{ csrf_field() }}
                        <input type="hidden" name="uniqid" value="{{ Auth::user()->uniqid }}">
                        <div class="form-group">
                            <label for="password" class="col-md-4 control-label">Nieuw wachtwoord</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password_new" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Reset
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
