<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BloodRequest;
use App\Models\Donor;
use Illuminate\Support\Facades\Mail;

class BloodRequestController extends Controller
{
    // Request blood form
    public function create()
    {
        return view('request.create');
    }

    // Store request and notify matching donors if urgent (Unit IV / V)
    public function store(Request $request)
    {
        $request->validate([
            'requester_name' => 'required|string|max:255',
            'blood_group' => 'required|string|in:A+,A-,B+,B-,O+,O-,AB+,AB-',
            'units_needed' => 'required|integer|min:1|max:20',
            'hospital' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'urgency' => 'required|string|in:normal,urgent',
        ]);

        $bloodRequest = BloodRequest::create($request->all());

        // Email Notification for Urgent Requests (Unit IV)
        if ($bloodRequest->urgency === 'urgent') {
            // Find donors in the same locality/city with matching blood group who are available
            $matchingDonors = Donor::where('city', $bloodRequest->city)
                ->where('blood_group', $bloodRequest->blood_group)
                ->where('is_available', true)
                ->get();

            foreach ($matchingDonors as $donor) {
                // Send email notification (logged in storage/logs/laravel.log due to MAIL_MAILER=log)
                Mail::send('emails.urgent_request', ['bloodRequest' => $bloodRequest, 'donor' => $donor], function ($message) use ($donor) {
                    $message->to($donor->email, $donor->name)
                            ->subject('URGENT: Blood Donation Request in Your Area!');
                });
            }
        }

        return redirect()->route('request.track', $bloodRequest->id)
            ->with('success', 'Blood request submitted successfully.');
    }

    // Track request status (Unit II / III Route Parameters)
    public function track($id)
    {
        $bloodRequest = BloodRequest::findOrFail($id);

        return view('request.track', compact('bloodRequest'));
    }

    // Update status (e.g. mark as matched or fulfilled)
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|string|in:pending,matched,fulfilled',
        ]);

        $bloodRequest = BloodRequest::findOrFail($id);
        $bloodRequest->status = $request->status;
        $bloodRequest->save();

        return redirect()->back()->with('success', 'Request status updated successfully.');
    }
}
