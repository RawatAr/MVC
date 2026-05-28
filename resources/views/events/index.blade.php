@extends('layouts.app')

@section('title', 'Upcoming Donation Drives')

@section('content')
<div class="page-header" id="events-header">
    <div>
        <h1>Upcoming Blood Donation Drives</h1>
        <p>Participate in local donation camps organized by verified hospitals and centers.</p>
    </div>
</div>

<div class="grid-2" style="margin-bottom: 2rem;">
    @forelse($events as $event)
        <div class="card event-card" id="event-card-{{ $event->id }}">
            <div class="event-date-box" style="width: 80px; height: 80px;">
                <span class="event-date-day" style="font-size: 1.75rem;">{{ $event->event_date->format('d') }}</span>
                <span class="event-date-month" style="font-size: 0.85rem;">{{ $event->event_date->format('M') }}</span>
            </div>
            <div>
                <h3 style="font-size: 1.25rem; margin-bottom: 0.25rem; font-weight: 700;">{{ $event->title }}</h3>
                <p style="font-size: 0.95rem; color: var(--color-accent); font-weight: 600; margin-bottom: 0.5rem;">
                    Hosted by: <a href="{{ route('blood-banks.show', $event->blood_bank_id) }}" style="text-decoration: underline;">{{ $event->bloodBank->name }}</a>
                </p>
                <p style="color: var(--text-muted); font-size: 0.9rem; margin-bottom: 1rem; line-height: 1.5;">
                    {{ $event->description }}
                </p>
                <div style="display: flex; gap: 1.5rem; font-size: 0.85rem; color: var(--text-muted);">
                    <div style="display: flex; align-items: center; gap: 0.25rem;">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10"/>
                            <polyline points="12 6 12 12 16 14"/>
                        </svg>
                        <span>Time: {{ $event->event_date->format('h:i A') }}</span>
                    </div>
                    <div style="display: flex; align-items: center; gap: 0.25rem;">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/>
                            <circle cx="12" cy="10" r="3"/>
                        </svg>
                        <span>Venue: {{ $event->location }}</span>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="card" style="grid-column: span 2; text-align: center; padding: 4rem 2rem;">
            <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" style="color: var(--text-muted); margin-bottom: 1rem;">
                <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
                <line x1="16" y1="2" x2="16" y2="6"/>
                <line x1="8" y1="2" x2="8" y2="6"/>
                <line x1="3" y1="10" x2="21" y2="10"/>
            </svg>
            <h3>No Scheduled Camps</h3>
            <p style="color: var(--text-muted); margin-top: 0.25rem;">There are no upcoming blood drives scheduled. Check back soon!</p>
        </div>
    @endforelse
</div>
@endsection
