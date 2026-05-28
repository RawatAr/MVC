<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Donor;
use App\Models\BloodRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class DonorController extends Controller
{
    // Registration form view
    public function create()
    {
        return view('donor.register');
    }

    // Store donor registration data
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:donors,email',
            'password' => 'required|string|min:6|confirmed',
            'phone' => 'required|string|min:10',
            'blood_group' => 'required|string|in:A+,A-,B+,B-,O+,O-,AB+,AB-',
            'city' => 'required|string|max:255',
            'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $data = $request->only(['name', 'email', 'phone', 'blood_group', 'city']);
        $data['password'] = Hash::make($request->password);
        $data['is_available'] = $request->has('is_available');

        // File upload handling for donor profile photo (Unit IV)
        if ($request->hasFile('profile_photo')) {
            $file = $request->file('profile_photo');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/donors'), $filename);
            $data['profile_photo'] = 'uploads/donors/' . $filename;
        }

        $donor = Donor::create($data);

        // Store Session data
        session([
            'donor_id' => $donor->id,
            'donor_name' => $donor->name,
            'donor_group' => $donor->blood_group,
            'donor_city' => $donor->city,
        ]);

        return redirect()->route('donor.dashboard')->with('success', 'Registration successful! Welcome to BloodLink.');
    }

    // Login form view
    public function loginForm()
    {
        if (session()->has('donor_id')) {
            return redirect()->route('donor.dashboard');
        }
        return view('donor.login');
    }

    // Authenticate donor
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $donor = Donor::where('email', $request->email)->first();

        if ($donor && Hash::check($request->password, $donor->password)) {
            // Store Session data
            session([
                'donor_id' => $donor->id,
                'donor_name' => $donor->name,
                'donor_group' => $donor->blood_group,
                'donor_city' => $donor->city,
            ]);

            // Set cookie for preferred locality (Unit IV)
            cookie()->queue('donor_locality', $donor->city, 60 * 24 * 30); // 30 days

            return redirect()->route('donor.dashboard')->with('success', 'Logged in successfully.');
        }

        return redirect()->back()->withInput()->with('error', 'Invalid email or password.');
    }

    // Donor dashboard (session-protected)
    public function dashboard()
    {
        $donorId = session('donor_id');
        $donor = Donor::findOrFail($donorId);

        // Fetch matching urgent/normal requests in donor's city and matching blood group
        $matchingRequests = BloodRequest::where('city', $donor->city)
            ->where('blood_group', $donor->blood_group)
            ->where('status', '!=', 'fulfilled')
            ->orderBy('urgency', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('donor.dashboard', compact('donor', 'matchingRequests'));
    }

    // Toggle availability
    public function toggleAvailability()
    {
        $donor = Donor::findOrFail(session('donor_id'));
        $donor->is_available = !$donor->is_available;
        $donor->save();

        return redirect()->back()->with('success', 'Availability status updated.');
    }

    // Logout and destroy session
    public function logout(Request $request)
    {
        // Destroy session data
        Session::flush();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')->with('success', 'Logged out successfully.');
    }
}
