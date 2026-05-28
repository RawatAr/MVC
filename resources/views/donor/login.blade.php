@extends('layouts.app')

@section('title', 'Donor Login')

@section('content')
<div class="form-page-container">
    <div class="form-header">
        <h2>Welcome Back</h2>
        <p>Login to update your availability and view matching requests.</p>
    </div>

    <div class="card">
        <form action="{{ route('donor.login.submit') }}" method="POST">
            @csrf

            <div class="form-group" style="margin-bottom: 1.25rem;">
                <label for="email">Email Address</label>
                <input type="email" name="email" id="email" class="form-input @error('email') is-invalid @enderror" value="{{ old('email') }}" required autocomplete="email" autofocus>
                @error('email')
                    <span style="color: var(--color-accent); font-size: 0.8rem; margin-top: 0.25rem;">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group" style="margin-bottom: 2rem;">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" class="form-input @error('password') is-invalid @enderror" required autocomplete="current-password">
                @error('password')
                    <span style="color: var(--color-accent); font-size: 0.8rem; margin-top: 0.25rem;">{{ $message }}</span>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary" style="width: 100%; height: 48px;">Login Account</button>
        </form>
    </div>

    <div class="form-footer-link">
        Don't have a donor profile? <a href="{{ route('donor.register') }}">Register here</a>
    </div>
</div>
@endsection
