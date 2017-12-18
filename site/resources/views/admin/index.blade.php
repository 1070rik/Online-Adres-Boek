@extends('layouts.admin')

@section('content')
<div class="row">
  <div class="col-md-8">
    <pre>
{{ $output }}
    </pre>
  </div>
  <div class="col-md-4">
    <button type="button" name="button" class="btn btn-danger big-button">Run test data</button>
  </div>
</div>
@endsection
