@extends('layouts.app')

@section('content')
<style>
    body {
        background: linear-gradient(135deg, #FFFFFFFF, #FEFEFFFF);
        background-attachment: fixed;
    }

    .login-card {
        border: none;
        border-radius: 1rem;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
        margin-top: 50px;
        padding: 2rem;
        background-color: #ffffff;
    }

    .login-header {
        font-size: 1.5rem;
        font-weight: bold;
        text-align: center;
        margin-bottom: 1.5rem;
        color: #2a5298;
    }

    .form-control {
        border-radius: 50px;
        padding-left: 2.5rem;
    }

    .form-icon {
        position: absolute;
        left: 15px;
        top: 50%;
        transform: translateY(-50%);
        color: #999;
    }

    .form-group {
        position: relative;
        margin-bottom: 1.5rem;
    }

    .btn-primary {
        border-radius: 50px;
        padding-left: 2rem;
        padding-right: 2rem;
    }

    .form-check-label {
        font-weight: 500;
    }

    .card-link {
        color: #F7F8FAFF;
    }

    .card-link:hover {
        text-decoration: underline;
    }
</style>

<div class="container d-flex justify-content-center align-items-center min-vh-90">
    <div class="col-md-3">
        <div class="card login-card">
            <div class="login-header">{{ __('Login to Your Account') }}</div>

            <div class="card-body">
                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="form-group">
                        <span class="form-icon"><i class="fas fa-user"></i></span>
                        <input id="login" type="text" class="form-control @error('login') is-invalid @enderror"
                            name="login" value="{{ old('login') }}" required autofocus
                            placeholder="Email or Admission Number">
                        @error('login')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <span class="form-icon"><i class="fas fa-lock"></i></span>
                        <input id="password" type="password"
                            class="form-control @error('password') is-invalid @enderror" name="password" required
                            placeholder="Password">
                        @error('password')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>

                    {{-- <div class="mb-3 d-flex justify-content-between align-items-center">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="remember"
                                id="remember" {{ old('remember') ? 'checked' : '' }}>
                            <label class="form-check-label" for="remember">
                                {{ __('Remember Me') }}
                            </label>
                        </div>
                        @if (Route::has('password.request'))
                            <a class="card-link" href="{{ route('password.request') }}">
                                {{ __('Forgot Password?') }}
                            </a>
                        @endif
                    </div> --}}

                    <div class="text-center">
                        <button type="submit" class="btn btn-primary">
                            {{ __('Login') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
