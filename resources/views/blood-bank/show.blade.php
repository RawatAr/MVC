@extends('layouts.app')

@section('title', $bank->name)

@section('styles')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
@endsection

@section('content')
<div style="margin-bottom: 2rem;">
    <a href="{{ route('blood-banks.index') }}" style="color: var(--text-muted); font-size: 0.9rem; display: inline-flex; align-items: center; gap: 0.25rem;">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
            <line x1="19" y1="12" x2="5" y2="12"/>
            <polyline points="12 19 5 12 12 5"/>
        </svg>
        Back to Directory
    </a>
</div>

<div class="grid-3" style="align-items: start; margin-bottom: 2rem; gap: 2rem;">
    <!-- Profile and Details (Column 1) -->
    <div style="grid-column: span 1; display: flex; flex-direction: column; gap: 1.5rem;">
        <div class="card">
            <h2 style="font-size: 1.5rem; margin-bottom: 0.5rem; line-height: 1.25;">{{ $bank->name }}</h2>
            <p style="margin-bottom: 1.5rem;">
                @if($bank->verified)
                    <span class="badge badge-green">Verified Facility</span>
                @else
                    <span class="badge badge-yellow">Unverified</span>
                @endif
            </p>
            
            <div style="display: flex; flex-direction: column; gap: 1rem; border-top: 1px solid var(--border-color); padding-top: 1.5rem;">
                <div>
                    <span style="color: var(--text-muted); font-size: 0.85rem; font-weight: 600; display: block; text-transform: uppercase; margin-bottom: 0.25rem;">Location</span>
                    <p style="font-weight: 500;">{{ $bank->address }}, {{ $bank->city }}</p>
                </div>
                <div>
                    <span style="color: var(--text-muted); font-size: 0.85rem; font-weight: 600; display: block; text-transform: uppercase; margin-bottom: 0.25rem;">Contact Helpline</span>
                    <p style="font-weight: 500; font-size: 1.1rem; color: var(--color-accent);">{{ $bank->contact }}</p>
                </div>
            </div>
        </div>

        <!-- Geo-Location Mini Map -->
        <div id="mini-map" style="height: 250px; border-radius: var(--radius-lg); border: 1px solid var(--border-color); z-index: 1;"></div>
    </div>

    <!-- Blood Units Stock Table (Columns 2 & 3) -->
    <div style="grid-column: span 2; display: flex; flex-direction: column; gap: 2rem;">
        <div class="card">
            <h3 style="margin-bottom: 1rem;">Blood Stock Inventory</h3>
            <p style="color: var(--text-muted); font-size: 0.9rem; margin-bottom: 1rem;">Real-time database of blood units available at this center.</p>
            
            <div class="table-wrapper">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Blood Group</th>
                            <th>Availability Status</th>
                            <th>Units Available</th>
                            <th>Last Refreshed</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($bank->stocks as $stock)
                            <tr>
                                <td>
                                    <div class="blood-group-circle" style="width: 36px; height: 36px; font-size: 0.85rem; box-shadow: none;">{{ $stock->blood_group }}</div>
                                </td>
                                <td>
                                    @if($stock->units_available > 5)
                                        <span class="badge badge-green">In Stock</span>
                                    @elseif($stock->units_available > 0)
                                        <span class="badge badge-yellow">Low Stock</span>
                                    @else
                                        <span class="badge badge-red">Out of Stock</span>
                                    @endif
                                </td>
                                <td><strong>{{ $stock->units_available }}</strong> Unit(s)</td>
                                <td style="color: var(--text-muted); font-size: 0.85rem;">{{ $stock->updated_at->diffForHumans() }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" style="text-align: center; color: var(--text-muted); padding: 2rem;">No stock records found for this center.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Events organized by this bank -->
        <div class="card">
            <h3 style="margin-bottom: 1.5rem;">Camps Hosted by Center</h3>
            <div style="display: flex; flex-direction: column; gap: 1rem;">
                @forelse($bank->events as $event)
                    <div class="event-card" style="background-color: rgba(255, 255, 255, 0.02); border: 1px solid var(--border-color); border-radius: var(--radius-md); padding: 1rem;">
                        <div class="event-date-box">
                            <span class="event-date-day">{{ $event->event_date->format('d') }}</span>
                            <span class="event-date-month">{{ $event->event_date->format('M') }}</span>
                        </div>
                        <div>
                            <h4 style="font-size: 1.05rem; margin-bottom: 0.25rem;">{{ $event->title }}</h4>
                            <p style="font-size: 0.85rem; color: var(--text-muted); margin-bottom: 0.25rem;">{{ $event->description }}</p>
                            <p style="font-size: 0.8rem; color: var(--color-accent);">Venue: {{ $event->location }}</p>
                        </div>
                    </div>
                @empty
                    <p style="color: var(--text-muted); font-size: 0.9rem; text-align: center; padding: 1rem 0;">No camps scheduled for this center currently.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var lat = {{ $bank->latitude ?? 28.6139 }};
            var lng = {{ $bank->longitude ?? 77.2090 }};
            
            var map = L.map('mini-map', {
                zoomControl: true,
                dragging: true,
                scrollWheelZoom: false
            }).setView([lat, lng], 13);

            L.tileLayer('https://{s}.basemaps.cartocdn.com/dark_all/{z}/{x}/{y}{r}.png', {
                attribution: '&copy; CARTO',
                maxZoom: 20
            }).addTo(map);

            var redIcon = L.icon({
                iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-red.png',
                shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
                iconSize: [25, 41],
                iconAnchor: [12, 41],
                popupAnchor: [1, -34],
                shadowSize: [41, 41]
            });

            var marker = L.marker([lat, lng], { icon: redIcon }).addTo(map);
            marker.bindPopup('<h4>{{ $bank->name }}</h4><p>{{ $bank->address }}</p>').openPopup();
        });
    </script>
@endsection
