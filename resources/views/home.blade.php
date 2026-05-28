@extends('layouts.app')

@section('meta_description', 'Find nearby blood banks, track live blood units availability and request emergency blood donations in real time.')

@section('title', 'Save Lives in Real Time')

@section('styles')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
@endsection

@section('content')
    <!-- Hero Section -->
    <section class="hero" id="home-hero">
        <div class="hero-text">
            <h1>Modernizing <span>Blood Donation</span> & Recipient Matching</h1>
            <p>Every second counts during medical emergencies. BloodLink bridges the gap between donors and seekers in your locality. Track live stock availability, raise requisitions instantly, and locate donation drives.</p>
            <div class="hero-actions">
                <a href="{{ route('request.create') }}" class="btn btn-primary">Need Blood Urgently</a>
                <a href="{{ route('donor.register') }}" class="btn btn-secondary">Register as a Donor</a>
            </div>
        </div>
        <div class="hero-image" style="display: flex; justify-content: center; align-items: center; position: relative;">
            <div class="blood-group-circle" style="width: 150px; height: 150px; font-size: 3rem; margin-right: -40px; z-index: 2; animation: bounce 3s infinite ease-in-out;">O-</div>
            <div class="blood-group-circle" style="width: 180px; height: 180px; font-size: 3.5rem; background: radial-gradient(circle at 30% 30%, #dc2626, #7f1d1d); box-shadow: 0 10px 30px rgba(220, 38, 38, 0.4); animation: bounce 3s infinite ease-in-out 1.5s;">A+</div>
            
            <style>
                @keyframes bounce {
                    0%, 100% { transform: translateY(0); }
                    50% { transform: translateY(-10px); }
                }
            </style>
        </div>
    </section>

    <!-- Quick Search Widget (Unit II / V) -->
    <section class="search-widget" id="quick-search-section">
        <h3 style="margin-bottom: 1.5rem; font-size: 1.25rem;">Quick Locality Search</h3>
        <form action="{{ route('blood-banks.index') }}" method="GET" class="search-form">
            <div class="form-group">
                <label for="search-city">Select City / Locality</label>
                <input type="text" name="city" id="search-city" placeholder="e.g. New York, San Jose" class="form-input" value="{{ request('city') }}">
            </div>
            <div class="form-group">
                <label for="search-blood-group">Required Blood Group</label>
                <select name="blood_group" id="search-blood-group" class="form-select">
                    <option value="">Any Blood Group</option>
                    @foreach(['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'] as $gp)
                        <option value="{{ $gp }}" {{ request('blood_group') == $gp ? 'selected' : '' }}>{{ $gp }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-primary" style="height: 48px; min-width: 150px;">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="margin-right: 0.25rem;">
                    <circle cx="11" cy="11" r="8"/>
                    <line x1="21" y1="21" x2="16.65" y2="16.65"/>
                </svg>
                Find Stocks
            </button>
        </form>
    </section>

    <!-- Statistics Section (Unit VI Query Builder / Eloquent ORM) -->
    <section class="stats-grid" id="stats-section">
        <div class="stat-card">
            <div class="stat-number">{{ $stats['donors_count'] }}</div>
            <div class="stat-label">Registered Donors</div>
        </div>
        <div class="stat-card">
            <div class="stat-number">{{ $stats['banks_count'] }}</div>
            <div class="stat-label">Blood Banks</div>
        </div>
        <div class="stat-card">
            <div class="stat-number">{{ $stats['requests_count'] }}</div>
            <div class="stat-label">Pending Requests</div>
        </div>
        <div class="stat-card">
            <div class="stat-number">{{ $stats['units_count'] }}</div>
            <div class="stat-label">Blood Units Available</div>
        </div>
    </section>

    <!-- Locality Geo-Tracking Map using Leaflet + OpenStreetMap -->
    <section style="margin-bottom: 4rem;">
        <h2 style="margin-bottom: 1.5rem; font-size: 1.75rem;">Geo-Tracking Nearby Blood Facilities</h2>
        <div id="map"></div>
    </section>

    <!-- Recent Emergency Requests & Events -->
    <div class="grid-2" style="margin-bottom: 2rem;">
        <!-- Emergency Requisitions -->
        <section class="card" style="display: flex; flex-direction: column;">
            <div class="card-title">
                <span>Active Requisitions</span>
                <span class="badge badge-red">Urgent</span>
            </div>
            
            <div style="display: flex; flex-direction: column; gap: 1rem; flex: 1;">
                @forelse($recentRequests as $request)
                    <div style="background-color: rgba(255, 255, 255, 0.02); border: 1px solid var(--border-color); border-radius: var(--radius-md); padding: 1rem; display: flex; align-items: center; justify-content: space-between; gap: 1rem;">
                        <div style="display: flex; align-items: center; gap: 1rem;">
                            <div class="blood-group-circle" style="width: 40px; height: 40px; font-size: 0.95rem; box-shadow: none;">{{ $request->blood_group }}</div>
                            <div>
                                <h4 style="font-size: 0.95rem;">{{ $request->hospital }}</h4>
                                <p style="font-size: 0.8rem; color: var(--text-muted);">{{ $request->units_needed }} Unit(s) needed • {{ $request->city }}</p>
                            </div>
                        </div>
                        <div style="display: flex; flex-direction: column; align-items: flex-end; gap: 0.5rem;">
                            @if($request->urgency === 'urgent')
                                <span class="badge badge-red" style="font-size: 0.65rem; padding: 0.15rem 0.4rem;">Emergency</span>
                            @else
                                <span class="badge badge-yellow" style="font-size: 0.65rem; padding: 0.15rem 0.4rem;">Normal</span>
                            @endif
                            <a href="{{ route('request.track', $request->id) }}" class="btn btn-secondary btn-sm" style="font-size: 0.75rem; padding: 0.25rem 0.6rem;">Track</a>
                        </div>
                    </div>
                @empty
                    <p style="color: var(--text-muted); text-align: center; margin: auto 0;">No active blood requests at the moment.</p>
                @endforelse
            </div>
        </section>

        <!-- Events and Camps -->
        <section class="card" style="display: flex; flex-direction: column;">
            <div class="card-title">
                <span>Upcoming Events</span>
                <a href="{{ route('events.index') }}" style="font-size: 0.8rem; color: var(--color-accent); font-weight: 600;">View All</a>
            </div>
            
            <div style="display: flex; flex-direction: column; gap: 1.25rem; flex: 1;">
                @forelse($upcomingEvents as $event)
                    <div class="event-card" style="background-color: rgba(255, 255, 255, 0.02); border: 1px solid var(--border-color); border-radius: var(--radius-md); padding: 1rem;">
                        <div class="event-date-box">
                            <span class="event-date-day">{{ $event->event_date->format('d') }}</span>
                            <span class="event-date-month">{{ $event->event_date->format('M') }}</span>
                        </div>
                        <div>
                            <h4 style="font-size: 1rem; margin-bottom: 0.25rem;">{{ $event->title }}</h4>
                            <p style="font-size: 0.85rem; color: var(--text-muted); margin-bottom: 0.25rem;">{{ $event->bloodBank->name }}</p>
                            <p style="font-size: 0.8rem; color: var(--color-accent);">{{ $event->location }}</p>
                        </div>
                    </div>
                @empty
                    <p style="color: var(--text-muted); text-align: center; margin: auto 0;">No donation camps scheduled soon.</p>
                @endforelse
            </div>
        </section>
    </div>
@endsection

@section('scripts')
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Center map around India
            var map = L.map('map').setView([23.5937, 78.9629], 5);

            // Load CartoDB Dark Matter tiles (premium dark mode theme)
            L.tileLayer('https://{s}.basemaps.cartocdn.com/dark_all/{z}/{x}/{y}{r}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors &copy; <a href="https://carto.com/attributions">CARTO</a>',
                subdomains: 'abcd',
                maxZoom: 20
            }).addTo(map);

            // Custom red pin icon
            var redIcon = L.icon({
                iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-red.png',
                shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
                iconSize: [25, 41],
                iconAnchor: [12, 41],
                popupAnchor: [1, -34],
                shadowSize: [41, 41]
            });

            // Add markers dynamically based on verified blood banks
            @foreach($mapBanks as $bank)
                @if($bank->latitude && $bank->longitude)
                    var marker = L.marker([{{ $bank->latitude }}, {{ $bank->longitude }}], { icon: redIcon }).addTo(map);
                    
                    var popupContent = '<h4>{{ $bank->name }}</h4>' +
                                       '<p><strong>City:</strong> {{ $bank->city }}</p>' +
                                       '<p><strong>Contact:</strong> {{ $bank->contact }}</p>' +
                                       '<a href="{{ route('blood-banks.show', $bank->id) }}">View Live Stock</a>';
                    
                    marker.bindPopup(popupContent);
                @endif
            @endforeach
        });
    </script>
@endsection
