@extends('layouts.app')

@section('title', 'Track Requisition')

@section('content')
<div class="form-page-container" style="max-width: 650px;">
    <div class="form-header">
        <h2>Blood Requisition Tracker</h2>
        <p>Monitor the status of blood request ID: #{{ $bloodRequest->id }}</p>
    </div>

    <!-- Tracker Visualizer -->
    <div class="card" style="margin-bottom: 2rem; padding: 2.5rem 1.5rem 1.5rem;">
        <div class="tracker-container">
            <div class="tracker-line">
                <div class="tracker-line-fill" style="width: 
                    @if($bloodRequest->status === 'pending')
                        0%
                    @elseif($bloodRequest->status === 'matched')
                        50%
                    @else
                        100%
                    @endif
                ;"></div>
            </div>
            <div class="tracker-steps">
                <!-- Step 1 -->
                <div class="tracker-step @if($bloodRequest->status === 'pending') active @elseif($bloodRequest->status === 'matched' || $bloodRequest->status === 'fulfilled') completed @endif">
                    <div class="tracker-icon">
                        @if($bloodRequest->status === 'matched' || $bloodRequest->status === 'fulfilled')
                            ✓
                        @else
                            1
                        @endif
                    </div>
                    <span class="tracker-label">Request Raised</span>
                </div>
                <!-- Step 2 -->
                <div class="tracker-step @if($bloodRequest->status === 'matched') active @elseif($bloodRequest->status === 'fulfilled') completed @endif">
                    <div class="tracker-icon">
                        @if($bloodRequest->status === 'fulfilled')
                            ✓
                        @else
                            2
                        @endif
                    </div>
                    <span class="tracker-label">Donor Matched</span>
                </div>
                <!-- Step 3 -->
                <div class="tracker-step @if($bloodRequest->status === 'fulfilled') active @endif">
                    <div class="tracker-icon">3</div>
                    <span class="tracker-label">Request Fulfilled</span>
                </div>
            </div>
        </div>
        
        <div style="text-align: center; margin-top: 2rem; padding-top: 1.5rem; border-top: 1px solid var(--border-color); font-size: 0.9rem; color: var(--text-muted);">
            Current Status: 
            @if($bloodRequest->status === 'pending')
                <strong style="color: var(--color-warning);">PENDING SEARCH</strong> - We are alert-notifying donors.
            @elseif($bloodRequest->status === 'matched')
                <strong style="color: var(--color-info);">DONORS MATCHED</strong> - Local donors have responded to this alert.
            @else
                <strong style="color: var(--color-success);">FULFILLED</strong> - Donation complete. Thank you to the donor!
            @endif
        </div>
    </div>

    <!-- Requisition Details -->
    <div class="card" style="margin-bottom: 2rem;">
        <h3 style="margin-bottom: 1.25rem;">Requisition Details</h3>
        <div style="display: flex; flex-direction: column; gap: 1rem;">
            <div style="display: flex; justify-content: space-between; border-bottom: 1px solid var(--border-color); padding-bottom: 0.75rem;">
                <span style="color: var(--text-muted);">Patient Name</span>
                <strong>{{ $bloodRequest->requester_name }}</strong>
            </div>
            <div style="display: flex; justify-content: space-between; border-bottom: 1px solid var(--border-color); padding-bottom: 0.75rem;">
                <span style="color: var(--text-muted);">Blood Group Needed</span>
                <span class="blood-group-circle" style="width: 28px; height: 28px; font-size: 0.75rem; box-shadow: none;">{{ $bloodRequest->blood_group }}</span>
            </div>
            <div style="display: flex; justify-content: space-between; border-bottom: 1px solid var(--border-color); padding-bottom: 0.75rem;">
                <span style="color: var(--text-muted);">Units Needed</span>
                <strong>{{ $bloodRequest->units_needed }} Unit(s)</strong>
            </div>
            <div style="display: flex; justify-content: space-between; border-bottom: 1px solid var(--border-color); padding-bottom: 0.75rem;">
                <span style="color: var(--text-muted);">Hospital</span>
                <strong>{{ $bloodRequest->hospital }}</strong>
            </div>
            <div style="display: flex; justify-content: space-between; border-bottom: 1px solid var(--border-color); padding-bottom: 0.75rem;">
                <span style="color: var(--text-muted);">Locality / City</span>
                <strong>{{ $bloodRequest->city }}</strong>
            </div>
            <div style="display: flex; justify-content: space-between; padding-bottom: 0.25rem;">
                <span style="color: var(--text-muted);">Urgency Priority</span>
                @if($bloodRequest->urgency === 'urgent')
                    <span class="badge badge-red">Urgent / Emergency</span>
                @else
                    <span class="badge badge-yellow">Normal</span>
                @endif
            </div>
        </div>
    </div>

    <!-- Admin Status Control (Mock Up for demo testing - Unit VI) -->
    <div class="card">
        <h3 style="margin-bottom: 1rem;">Update Requisition Status</h3>
        <p style="color: var(--text-muted); font-size: 0.85rem; margin-bottom: 1.25rem;">For testing purposes, you can manually transition this request between states.</p>
        
        <form action="{{ route('request.update-status', $bloodRequest->id) }}" method="POST">
            @csrf
            <div style="display: flex; gap: 1rem;">
                <select name="status" class="form-select" style="flex: 1;">
                    <option value="pending" {{ $bloodRequest->status === 'pending' ? 'selected' : '' }}>Pending Search</option>
                    <option value="matched" {{ $bloodRequest->status === 'matched' ? 'selected' : '' }}>Donor Matched</option>
                    <option value="fulfilled" {{ $bloodRequest->status === 'fulfilled' ? 'selected' : '' }}>Fulfilled</option>
                </select>
                <button type="submit" class="btn btn-secondary">Update Status</button>
            </div>
        </form>
    </div>
</div>
@endsection
