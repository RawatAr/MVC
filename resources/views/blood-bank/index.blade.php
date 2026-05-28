@extends('layouts.app')

@section('title', 'Blood Banks Directory')

@section('content')
<div class="page-header" id="banks-header">
    <div>
        <h1>Blood Banks Directory</h1>
        <p>Find verified blood banks and check real-time stock units availability.</p>
    </div>
</div>

<!-- Search Form Card -->
<div class="card" style="margin-bottom: 2rem;">
    <form action="{{ route('blood-banks.index') }}" method="GET" class="search-form">
        <div class="form-group">
            <label for="city">Search City</label>
            <select name="city" id="city" class="form-select">
                <option value="">All Cities</option>
                @foreach($cities as $c)
                    <option value="{{ $c }}" {{ $city == $c ? 'selected' : '' }}>{{ $c }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="blood_group">Requires Blood Group</label>
            <select name="blood_group" id="blood_group" class="form-select">
                <option value="">Any Blood Group</option>
                @foreach(['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'] as $gp)
                    <option value="{{ $gp }}" {{ $bloodGroup == $gp ? 'selected' : '' }}>{{ $gp }}</option>
                @endforeach
            </select>
        </div>
        <div style="display: flex; gap: 0.5rem;">
            <button type="submit" class="btn btn-primary" style="height: 48px; flex: 1;">Filter Results</button>
            @if($city || $bloodGroup)
                <a href="{{ route('blood-banks.index') }}" class="btn btn-secondary" style="height: 48px; display: flex; align-items: center; justify-content: center; padding: 0 1rem;">Clear</a>
            @endif
        </div>
    </form>
</div>

<!-- Results List -->
@if(count($banks) > 0)
    <div class="table-wrapper" id="banks-table-wrapper">
        <table class="table">
            <thead>
                <tr>
                    <th>Center Name</th>
                    <th>City</th>
                    <th>Address</th>
                    <th>Contact</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($banks as $bank)
                    <tr id="bank-row-{{ $bank->id }}">
                        <td>
                            <strong style="display: block; font-size: 1.05rem;">{{ $bank->name }}</strong>
                        </td>
                        <td>{{ $bank->city }}</td>
                        <td style="color: var(--text-muted); font-size: 0.9rem;">{{ $bank->address }}</td>
                        <td>{{ $bank->contact }}</td>
                        <td>
                            @if($bank->verified)
                                <span class="badge badge-green">Verified</span>
                            @else
                                <span class="badge badge-yellow">Unverified</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('blood-banks.show', $bank->id) }}" class="btn btn-secondary btn-sm">Check Stock</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@else
    <div class="card" style="text-align: center; padding: 4rem 2rem;">
        <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" style="color: var(--text-muted); margin-bottom: 1rem;">
            <circle cx="12" cy="12" r="10"/>
            <line x1="8" y1="12" x2="16" y2="12"/>
        </svg>
        <h3>No Centers Found</h3>
        <p style="color: var(--text-muted); margin-top: 0.25rem;">Try choosing a different city or clearing your filters.</p>
    </div>
@endif
@endsection
