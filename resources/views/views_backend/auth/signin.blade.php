@extends('views_backend.layouts.auth')

@section('title', 'Sign In - LayApp')

@section('content')
<div class="container d-flex align-items-center justify-content-center min-vh-100">
  <div class="card " style="max-width:420px; width:100%;">
    <div class="card-body p-5">
      <div class="text-center mb-3">
        <a href="{{ route('home') }}" class="mb-4 d-inline-block">
          <img src="{{ asset('images/backend/logo-icon.svg') }}" alt="" width="36">
          <span class=" ms-2"><img src="{{ asset('images/backend/logo.svg') }}" alt=""></span>
        </a>
        <h1 class="card-title mb-5 h5">Sign in to your account</h1>
      </div>

      @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
          @foreach ($errors->all() as $error)
            <div>{{ $error }}</div>
          @endforeach
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      @endif

      <form method="POST" action="{{ route('auth.authenticate') }}" class="needs-validation" novalidate>
        @csrf
        <div class="mb-3">
          <label for="email" class="form-label">Email address</label>
          <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" placeholder="name@example.com" value="{{ old('email') }}" required autofocus>
          @error('email')
            <div class="invalid-feedback d-block">{{ $message }}</div>
          @enderror
        </div>

        <div class="mb-3">
          <label for="password" class="form-label d-flex justify-content-between">
            <span>Password</span>
            <a href="#" class="small link-primary">Forgot Password?</a>
          </label>
          <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="Password" required minlength="6">
          @error('password')
            <div class="invalid-feedback d-block">{{ $message }}</div>
          @enderror
        </div>

        <div class="d-flex justify-content-between align-items-center mb-3">
          <div class="form-check">
            <input id="remember" class="form-check-input" type="checkbox" name="remember">
            <label class="form-check-label small" for="remember">Remember me</label>
          </div>
        </div>

        <button class="btn btn-primary w-100" type="submit">Sign in</button>
      </form>

      <div class="text-center mt-3 small text-muted">
        Don't have an account? <a href="{{ route('auth.signup') }}"  class="link-primary">Sign up</a>
      </div>
    </div>
  </div>
</div>
@endsection
