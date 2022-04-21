@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card text-center border-secondary">
        <div class="card-header">{{ __('Dashboard') }}</div>

        <div class="card-body">

          @if (session('status'))
              <div class="alert alert-success" role="alert">
                  {{ session('status') }}
              </div>
          @endif

          {{ __('You are logged in!') }}
          <h2>Welcome</h2>
          <p>This is the landing page</p>
          <p>
            <a class="btn btn-primary" href="{{ route('login') }}">{{ __('Login') }}</a>
            <a class="btn btn-success" href="{{ route('register') }}">{{ __('Register') }}</a>
          </p>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection