<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BloodBank;
use Illuminate\Support\Facades\DB;

class BloodBankController extends Controller
{
    // List all blood banks, filter by city (Query Builder used for locality filter - Unit VI)
    public function index(Request $request)
    {
        $city = $request->query('city');
        $bloodGroup = $request->query('blood_group');

        // Retrieve preferred locality from cookie if no search city is provided (Unit IV)
        if (!$city && $request->hasCookie('donor_locality')) {
            $city = $request->cookie('donor_locality');
        }

        // Query Builder usage (Unit VI)
        $query = DB::table('blood_banks');

        if ($city) {
            $query->where('city', 'like', '%' . $city . '%');
        }

        $banksRaw = $query->get();

        // Convert raw database objects to Eloquent instances to load relations
        $banks = BloodBank::hydrate($banksRaw->toArray());
        
        // Eager load stocks and events
        $banks->load('stocks');

        // If filtering by blood group, filter banks that have stock of that group > 0
        if ($bloodGroup) {
            $banks = $banks->filter(function ($bank) use ($bloodGroup) {
                return $bank->stocks->where('blood_group', $bloodGroup)->where('units_available', '>', 0)->count() > 0;
            });
        }

        // Get unique cities for search filter dropdown
        $cities = DB::table('blood_banks')->distinct()->pluck('city');

        return view('blood-bank.index', compact('banks', 'cities', 'city', 'bloodGroup'));
    }

    // Detail view of a specific blood bank (Unit II / III Route parameters)
    public function show($id)
    {
        // Route parameter constraints handled in routes, load model
        $bank = BloodBank::with(['stocks', 'events'])->findOrFail($id);

        return view('blood-bank.show', compact('bank'));
    }

    // REST API Endpoint returning JSON response (Unit VI / II)
    public function stockApi($id)
    {
        $bank = BloodBank::with('stocks')->find($id);

        if (!$bank) {
            return response()->json(['error' => 'Blood bank not found'], 404);
        }

        return response()->json([
            'bank_name' => $bank->name,
            'city' => $bank->city,
            'verified' => $bank->verified,
            'stocks' => $bank->stocks,
            'latitude' => $bank->latitude,
            'longitude' => $bank->longitude
        ]);
    }
}
