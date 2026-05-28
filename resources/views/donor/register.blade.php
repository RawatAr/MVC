@extends('layouts.app')

@section('title', 'Become a Blood Donor')

@section('content')
<div class="form-page-container">
    <div class="form-header">
        <h2>Register as a Donor</h2>
        <p>Your small act of kindness can save up to three lives.</p>
    </div>

    <div class="card">
        <form action="{{ route('donor.register.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-group" style="margin-bottom: 1.25rem;">
                <label for="name">Full Name</label>
                <input type="text" name="name" id="name" class="form-input @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
                @error('name')
                    <span style="color: var(--color-accent); font-size: 0.8rem; margin-top: 0.25rem;">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group" style="margin-bottom: 1.25rem;">
                <label for="email">Email Address</label>
                <input type="email" name="email" id="email" class="form-input @error('email') is-invalid @enderror" value="{{ old('email') }}" required>
                @error('email')
                    <span style="color: var(--color-accent); font-size: 0.8rem; margin-top: 0.25rem;">{{ $message }}</span>
                @enderror
            </div>

            <div class="grid-2" style="gap: 1rem; margin-bottom: 1.25rem;">
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" class="form-input @error('password') is-invalid @enderror" required>
                    @error('password')
                        <span style="color: var(--color-accent); font-size: 0.8rem; margin-top: 0.25rem;">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="password_confirmation">Confirm Password</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-input" required>
                </div>
            </div>

            <div class="grid-2" style="gap: 1rem; margin-bottom: 1.25rem;">
                <div class="form-group">
                    <label for="phone">Phone Number</label>
                    <input type="text" name="phone" id="phone" class="form-input @error('phone') is-invalid @enderror" value="{{ old('phone') }}" required>
                    @error('phone')
                        <span style="color: var(--color-accent); font-size: 0.8rem; margin-top: 0.25rem;">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="blood_group">Blood Group</label>
                    <select name="blood_group" id="blood_group" class="form-select @error('blood_group') is-invalid @enderror" required>
                        <option value="">Select Group</option>
                        @foreach(['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'] as $gp)
                            <option value="{{ $gp }}" {{ old('blood_group') == $gp ? 'selected' : '' }}>{{ $gp }}</option>
                        @endforeach
                    </select>
                    @error('blood_group')
                        <span style="color: var(--color-accent); font-size: 0.8rem; margin-top: 0.25rem;">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="form-group" style="margin-bottom: 1.25rem;">
                <label for="city">City / Locality</label>
                <input type="text" name="city" id="city" class="form-input @error('city') is-invalid @enderror" value="{{ old('city') }}" required>
                @error('city')
                    <span style="color: var(--color-accent); font-size: 0.8rem; margin-top: 0.25rem;">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group" style="margin-bottom: 1.5rem;">
                <label for="profile_photo">Profile Photo</label>
                <input type="file" name="profile_photo" id="profile_photo" class="form-input @error('profile_photo') is-invalid @enderror" style="padding: 0.5rem 1rem;">
                @error('profile_photo')
                    <span style="color: var(--color-accent); font-size: 0.8rem; margin-top: 0.25rem;">{{ $message }}</span>
                @enderror
            </div>

            <div class="switch-group" style="margin-bottom: 2rem;">
                <label class="switch">
                    <input type="checkbox" name="is_available" id="is_available" value="1" {{ old('is_available', '1') ? 'checked' : '' }}>
                    <span class="slider"></span>
                </label>
                <div>
                    <label for="is_available" style="font-weight: 600; font-size: 0.95rem; cursor: pointer;">Available to Donate</label>
                    <p style="font-size: 0.8rem; color: var(--text-muted);">Toggle off if you are temporarily unable to donate.</p>
                </div>
            </div>

            <button type="submit" class="btn btn-primary" style="width: 100%; height: 48px;">Complete Registration</button>
        </form>
    </div>

    <div class="form-footer-link">
        Already registered? <a href="{{ route('donor.login') }}">Login here</a>
    </div>
</div>
@endsection
