@extends('layouts.app')

@section('content')
<style>
    body {
        background: linear-gradient(135deg, #FFFFFF, #FFFFFF);
        background-attachment: fixed;
    }

    .register-card {
        border: none;
        border-radius: 1rem;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
        margin-top: 40px;
        padding: 2rem;
        background-color: #ffffff;
    }

    .register-header {
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

    label {
        font-weight: 500;
    }
</style>

<div class="container d-flex justify-content-center align-items-center min-vh-90">
    <div class="col-md-4">
        <div class="card register-card">
            <div class="register-header">{{ __('Register Your Account') }}</div>

            <div class="card-body">
                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <div class="form-group">
                        <span class="form-icon"><i class="fas fa-user"></i></span>
                        <input id="name" type="text" placeholder="Full Name"
                            class="form-control @error('name') is-invalid @enderror"
                            name="name" value="{{ old('name') }}" required autofocus>
                        @error('name')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <span class="form-icon"><i class="fas fa-id-card"></i></span>
                        <input id="admission_number" type="text" placeholder="Admission Number"
                            class="form-control @error('admission_number') is-invalid @enderror"
                            name="admission_number" value="{{ old('admission_number') }}" required>
                        @error('admission_number')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <span class="form-icon"><i class="fas fa-book"></i></span>
                        <select id="course" class="form-control @error('course') is-invalid @enderror" name="course" required>
                            <option value="">Select Course</option>
                            @foreach($courses as $course)
                                <option value="{{ $course->name }}" {{ old('course') == $course->name ? 'selected' : '' }}>
                                    {{ $course->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('course')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <span class="form-icon"><i class="fas fa-user-shield"></i></span>
                        <select id="role" class="form-control @error('role') is-invalid @enderror" name="role">
                            <option value="student" {{ old('role') == 'student' ? 'selected' : '' }}>Student</option>
                            <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                        </select>
                        @error('role')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <span class="form-icon"><i class="fas fa-lock"></i></span>
                        <input id="password" type="password" placeholder="Password"
                            class="form-control @error('password') is-invalid @enderror" name="password" required>
                        @error('password')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <span class="form-icon"><i class="fas fa-lock"></i></span>
                        <input id="password-confirm" type="password" placeholder="Confirm Password"
                            class="form-control" name="password_confirmation" required>
                    </div>

                    <div class="text-center">
                        <button type="submit" class="btn btn-primary">
                            {{ __('Register') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
