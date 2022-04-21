@extends('layouts.app')

@section('content')
<div class="container mt-4">
  <div class="row justify-content-center">
    <div class="col-md-6">
      <div class="card text-center border-success">
        <div class="card-header">
          <h3>Services</h3>
        </div>

        <div class="card-body">

          @if (session('status'))
            <div class="alert alert-success" role="alert">
              {{ session('status') }}
            </div>
          @endif

          <h4>This is the <strong>Services</strong> page.</h4>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
