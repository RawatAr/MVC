@extends('layouts.app')

@section('title', 'Donor Dashboard')

@section('content')
<div class="page-header" id="dashboard-header">
    <div>
        <h1>Donor Dashboard</h1>
        <p>Manage your donation status and respond to local needs.</p>
    </div>
</div>

<div class="grid-3" style="align-items: start; margin-bottom: 2rem;">
    <!-- Profile Widget Column (1st column) -->
    <div class="card" style="grid-column: span 1;">
        <div class="donor-profile-header">
            <div class="donor-avatar">
                @if($donor->profile_photo)
                    <img src="{{ asset($donor->profile_photo) }}" alt="{{ $donor->name }}">
                @else
                    <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                        <circle cx="12" cy="7" r="4"/>
                    </svg>
                @endif
            </div>
            <div class="donor-name-details">
                <h3>{{ $donor->name }}</h3>
                <p>Registered Donor</p>
            </div>
        </div>

        <div style="display: flex; flex-direction: column; gap: 1rem; border-top: 1px solid var(--border-color); padding-top: 1.5rem;">
            <div style="display: flex; justify-content: space-between;">
                <span style="color: var(--text-muted); font-size: 0.9rem;">Blood Group</span>
                <span class="blood-group-circle" style="width: 32px; height: 32px; font-size: 0.8rem; box-shadow: none;">{{ $donor->blood_group }}</span>
            </div>
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <span style="color: var(--text-muted); font-size: 0.9rem;">Location</span>
                <span style="font-weight: 600;">{{ $donor->city }}</span>
            </div>
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <span style="color: var(--text-muted); font-size: 0.9rem;">Phone</span>
                <span style="font-weight: 600;">{{ $donor->phone }}</span>
            </div>
            <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 0.5rem; border-top: 1px solid var(--border-color); padding-top: 1rem;">
                <div>
                    <span style="font-weight: 600; font-size: 0.95rem; display: block;">Availability Status</span>
                    <span style="font-size: 0.8rem; color: var(--text-muted);">
                        @if($donor->is_available)
                            Receiving request alerts
                        @else
                            Alerts paused
                        @endif
                    </span>
                </div>
                <form action="{{ route('donor.availability.toggle') }}" method="POST" id="toggle-availability-form">
                    @csrf
                    <label class="switch">
                        <input type="checkbox" name="availability" onchange="document.getElementById('toggle-availability-form').submit()" {{ $donor->is_available ? 'checked' : '' }}>
                        <span class="slider"></span>
                    </label>
                </form>
            </div>
        </div>
    </div>

    <!-- Matching Local Requests (2nd and 3rd columns) -->
    <div class="card" style="grid-column: span 2; min-height: 380px; display: flex; flex-direction: column;">
        <h3 style="margin-bottom: 1.5rem; display: flex; align-items: center; justify-content: space-between;">
            <span>Matching Blood Requisitions in {{ $donor->city }}</span>
            <span class="badge badge-red">{{ $matchingRequests->count() }} Match(es)</span>
        </h3>

        <div style="display: flex; flex-direction: column; gap: 1.25rem; flex: 1;">
            @forelse($matchingRequests as $req)
                <div style="background-color: rgba(255, 255, 255, 0.015); border: 1px solid var(--border-color); border-radius: var(--radius-md); padding: 1.25rem; display: flex; justify-content: space-between; align-items: center; gap: 1.5rem;">
                    <div>
                        <div style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 0.5rem;">
                            <span class="badge badge-red" style="font-size: 0.65rem;">{{ $req->blood_group }} Group</span>
                            @if($req->urgency === 'urgent')
                                <span class="badge badge-red" style="font-size: 0.65rem;">Emergency Alert</span>
                            @else
                                <span class="badge badge-yellow" style="font-size: 0.65rem;">Normal Request</span>
                            @endif
                            <span style="font-size: 0.8rem; color: var(--text-muted);">Raised {{ $req->created_at->diffForHumans() }}</span>
                        </div>
                        <h4 style="font-size: 1.1rem; margin-bottom: 0.25rem;">{{ $req->hospital }}</h4>
                        <p style="font-size: 0.85rem; color: var(--text-muted);">Requester: {{ $req->requester_name }} • Units Needed: <strong>{{ $req->units_needed }}</strong></p>
                    </div>
                    <div style="display: flex; flex-direction: column; gap: 0.5rem; align-items: flex-end;">
                        <a href="{{ route('request.track', $req->id) }}" class="btn btn-primary btn-sm">Respond & Track</a>
                    </div>
                </div>
            @empty
                <div style="display: flex; flex-direction: column; align-items: center; justify-content: center; text-align: center; margin: auto 0; padding: 2rem;">
                    <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" style="color: var(--text-muted); margin-bottom: 1rem;">
                        <circle cx="12" cy="12" r="10"/>
                        <path d="m9 12 2 2 4-4"/>
                    </svg>
                    <h4 style="margin-bottom: 0.25rem;">All Clear!</h4>
                    <p style="color: var(--text-muted); font-size: 0.9rem;">There are no active matching requests for blood group {{ $donor->blood_group }} in {{ $donor->city }} right now.</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
