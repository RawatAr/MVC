<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;

class EventController extends Controller
{
    // List upcoming events drives
    public function index()
    {
        $events = Event::with('bloodBank')
            ->where('event_date', '>=', now())
            ->orderBy('event_date', 'asc')
            ->get();

        return view('events.index', compact('events'));
    }
}
