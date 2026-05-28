<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="@yield('meta_description', 'Modernizing blood donation and recipient matching in real time.')">
    <title>@yield('title', 'BloodLink') - Blood Donation & Finder</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    
    <!-- Stylesheets -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    @yield('styles')
</head>
<body>

    <!-- Header Navigation -->
    <header class="header">
        <nav class="navbar" id="app-navbar">
            <a href="{{ route('home') }}" class="logo">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" style="color: var(--color-accent);">
                    <path d="M12 2C12 2 4 8 4 12C4 16.4183 7.58172 20 12 20C16.4183 20 20 16.4183 20 12C20 8 12 2 12 2Z"/>
                </svg>
                Blood<span>Link</span>
            </a>
            
            <ul class="nav-links">
                <li><a href="{{ route('home') }}" class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}">Home</a></li>
                <li><a href="{{ route('blood-banks.index') }}" class="nav-link {{ request()->routeIs('blood-banks.*') ? 'active' : '' }}">Blood Banks</a></li>
                <li><a href="{{ route('request.create') }}" class="nav-link {{ request()->routeIs('request.create') ? 'active' : '' }}">Find Blood</a></li>
                <li><a href="{{ route('events.index') }}" class="nav-link {{ request()->routeIs('events.*') ? 'active' : '' }}">Events</a></li>
            </ul>
            
            <div class="nav-buttons">
                @if(session()->has('donor_id'))
                    <a href="{{ route('donor.dashboard') }}" class="btn btn-secondary btn-sm">Dashboard</a>
                    <a href="{{ route('donor.logout') }}" class="btn btn-primary btn-sm">Logout</a>
                @else
                    <a href="{{ route('donor.login') }}" class="btn btn-secondary btn-sm">Login</a>
                    <a href="{{ route('donor.register') }}" class="btn btn-primary btn-sm">Become a Donor</a>
                @endif
            </div>
        </nav>
    </header>

    <!-- Main Content Area -->
    <main class="main-content" id="main-content-section">
        <!-- Display Session Alerts -->
        @if(session('success'))
            <div class="alert alert-success" id="alert-success-box">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
                    <polyline points="22 4 12 14.01 9 11.01"/>
                </svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-error" id="alert-error-box">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"/>
                    <line x1="12" y1="8" x2="12" y2="12"/>
                    <line x1="12" y1="16" x2="12.01" y2="16"/>
                </svg>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="footer">
        <div class="footer-content">
            <div class="footer-section">
                <h3>BloodLink</h3>
                <p>Modernizing blood donation facility. Connecting blood donors with seekers in real time to save lives in emergencies.</p>
            </div>
            <div class="footer-section">
                <h3>Quick Links</h3>
                <ul class="footer-links">
                    <li><a href="{{ route('blood-banks.index') }}">Locate Blood Banks</a></li>
                    <li><a href="{{ route('request.create') }}">Raise Blood Requisition</a></li>
                    <li><a href="{{ route('events.index') }}">Donation Events</a></li>
                </ul>
            </div>
            <div class="footer-section">
                <h3>Contact</h3>
                <p>Support: support@bloodlink.org<br>Emergency: +1 (800) 555-0199</p>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; {{ date('Y') }} BloodLink. Developed under INT221 MVC Programming.</p>
        </div>
    </footer>

    @yield('scripts')
</body>
</html>
