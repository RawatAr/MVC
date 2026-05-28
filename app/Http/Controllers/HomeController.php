<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Donor;
use App\Models\BloodBank;
use App\Models\BloodRequest;
use App\Models\Event;
use App\Models\BloodStock;

class HomeController extends Controller
{
    // Render the landing page with statistics and summaries
    public function index()
    {
        $stats = [
            'donors_count' => Donor::count(),
            'banks_count' => BloodBank::count(),
            'requests_count' => BloodRequest::where('status', 'pending')->count(),
            'units_count' => BloodStock::sum('units_available'),
        ];

        // Fetch 3 upcoming blood donation events
        $upcomingEvents = Event::with('bloodBank')
            ->where('event_date', '>=', now())
            ->orderBy('event_date', 'asc')
            ->limit(3)
            ->get();

        // Fetch a list of blood requests to showcase on the home page
        $recentRequests = BloodRequest::where('status', '!=', 'fulfilled')
            ->orderBy('urgency', 'desc')
            ->orderBy('created_at', 'desc')
            ->limit(4)
            ->get();

        // Fetch all verified blood banks with their locations for map display
        $mapBanks = BloodBank::where('verified', true)
            ->get(['id', 'name', 'city', 'latitude', 'longitude', 'contact']);

        return view('home', compact('stats', 'upcomingEvents', 'recentRequests', 'mapBanks'));
    }
}
