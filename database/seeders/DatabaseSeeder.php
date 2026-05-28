<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Donor;
use App\Models\BloodBank;
use App\Models\BloodStock;
use App\Models\Event;
use App\Models\BloodRequest;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Seed Donors (Indian names, phone numbers, and cities)
        $donors = [
            [
                'name' => 'Aryan Rawat',
                'email' => 'aryan@example.com',
                'password' => Hash::make('password'),
                'phone' => '+91 98765 43210',
                'blood_group' => 'O+',
                'city' => 'Dehradun',
                'is_available' => true,
            ],
            [
                'name' => 'Anjana Kumari',
                'email' => 'anjana@example.com',
                'password' => Hash::make('password'),
                'phone' => '+91 87654 32109',
                'blood_group' => 'B+',
                'city' => 'Delhi',
                'is_available' => true,
            ],
            [
                'name' => 'Gaurav',
                'email' => 'gaurav@example.com',
                'password' => Hash::make('password'),
                'phone' => '+91 76543 21098',
                'blood_group' => 'A+',
                'city' => 'Mumbai',
                'is_available' => true,
            ],
            [
                'name' => 'Amit Sharma',
                'email' => 'amit@example.com',
                'password' => Hash::make('password'),
                'phone' => '+91 91234 56789',
                'blood_group' => 'O-',
                'city' => 'Delhi',
                'is_available' => true,
            ],
            [
                'name' => 'Priyanshu Negi',
                'email' => 'priyanshu@example.com',
                'password' => Hash::make('password'),
                'phone' => '+91 92345 67890',
                'blood_group' => 'AB+',
                'city' => 'Dehradun',
                'is_available' => true,
            ],
            [
                'name' => 'Rohan Patel',
                'email' => 'rohan@example.com',
                'password' => Hash::make('password'),
                'phone' => '+91 93456 78901',
                'blood_group' => 'B-',
                'city' => 'Ahmedabad',
                'is_available' => true,
            ],
            [
                'name' => 'Sneha Reddy',
                'email' => 'sneha@example.com',
                'password' => Hash::make('password'),
                'phone' => '+91 94567 89012',
                'blood_group' => 'A-',
                'city' => 'Bangalore',
                'is_available' => true,
            ],
            [
                'name' => 'Vikram Sen',
                'email' => 'vikram@example.com',
                'password' => Hash::make('password'),
                'phone' => '+91 95678 90123',
                'blood_group' => 'O+',
                'city' => 'Kolkata',
                'is_available' => true,
            ],
            [
                'name' => 'Deepika Rao',
                'email' => 'deepika@example.com',
                'password' => Hash::make('password'),
                'phone' => '+91 96789 01234',
                'blood_group' => 'AB-',
                'city' => 'Hyderabad',
                'is_available' => true,
            ],
            [
                'name' => 'Kavin Kumar',
                'email' => 'kavin@example.com',
                'password' => Hash::make('password'),
                'phone' => '+91 97890 12345',
                'blood_group' => 'B+',
                'city' => 'Chennai',
                'is_available' => true,
            ],
            [
                'name' => 'Rahul Joshi',
                'email' => 'rahul@example.com',
                'password' => Hash::make('password'),
                'phone' => '+91 98901 23456',
                'blood_group' => 'A+',
                'city' => 'Pune',
                'is_available' => true,
            ],
            [
                'name' => 'Meera Nair',
                'email' => 'meera@example.com',
                'password' => Hash::make('password'),
                'phone' => '+91 99012 34567',
                'blood_group' => 'O+',
                'city' => 'Bangalore',
                'is_available' => false,
            ]
        ];

        foreach ($donors as $donorData) {
            Donor::create($donorData);
        }

        // 2. Seed Blood Banks in Indian Cities (10 hospitals/centers)
        $banks = [
            [
                'name' => 'IMA Blood Bank Dehradun',
                'address' => '12 Rajpur Road, Near Astley Hall',
                'city' => 'Dehradun',
                'contact' => '+91 135 2712345',
                'verified' => true,
                'latitude' => 30.324427,
                'longitude' => 78.046537,
            ],
            [
                'name' => 'Rotary Blood Bank Delhi',
                'address' => '15, Institutional Area, Okhla Phase 3',
                'city' => 'Delhi',
                'contact' => '+91 11 29054321',
                'verified' => true,
                'latitude' => 28.535516,
                'longitude' => 77.263931,
            ],
            [
                'name' => 'Wadia Hospital Blood Center Mumbai',
                'address' => 'Acharya Donde Marg, Parel East',
                'city' => 'Mumbai',
                'contact' => '+91 22 24177000',
                'verified' => true,
                'latitude' => 19.002492,
                'longitude' => 72.842323,
            ],
            [
                'name' => 'Narayana Health Blood Bank Bangalore',
                'address' => '258/A, Bommasandra Industrial Area, Hosur Road',
                'city' => 'Bangalore',
                'contact' => '+91 80 71222222',
                'verified' => true,
                'latitude' => 12.812301,
                'longitude' => 77.694562,
            ],
            [
                'name' => 'Apollo Hospital Blood Center Chennai',
                'address' => '21, Greams Lane, Off Greams Road',
                'city' => 'Chennai',
                'contact' => '+91 44 28290200',
                'verified' => true,
                'latitude' => 13.060422,
                'longitude' => 80.249583,
            ],
            [
                'name' => 'Ruby Hall Clinic Blood Bank Pune',
                'address' => '40, Sassoon Road, Near Pune Station',
                'city' => 'Pune',
                'contact' => '+91 20 66455100',
                'verified' => true,
                'latitude' => 18.530822,
                'longitude' => 73.873531,
            ],
            [
                'name' => 'Woodlands Hospital Blood Bank Kolkata',
                'address' => '8/B, Alipore Road',
                'city' => 'Kolkata',
                'contact' => '+91 33 24567000',
                'verified' => true,
                'latitude' => 22.535489,
                'longitude' => 88.330811,
            ],
            [
                'name' => 'Yashoda Hospital Blood Bank Hyderabad',
                'address' => 'Raj Bhavan Road, Somajiguda',
                'city' => 'Hyderabad',
                'contact' => '+91 40 45674567',
                'verified' => true,
                'latitude' => 17.422312,
                'longitude' => 78.452391,
            ],
            [
                'name' => 'Civil Hospital Blood Bank Ahmedabad',
                'address' => 'Asarwa, Near Haripura',
                'city' => 'Ahmedabad',
                'contact' => '+91 79 22683721',
                'verified' => true,
                'latitude' => 23.051289,
                'longitude' => 72.601292,
            ],
            [
                'name' => 'SGPGI Blood Center Lucknow',
                'address' => 'New PMSSY Building, Raebareli Road',
                'city' => 'Lucknow',
                'contact' => '+91 522 2668700',
                'verified' => true,
                'latitude' => 26.846693,
                'longitude' => 80.946166,
            ]
        ];

        $createdBanks = [];
        foreach ($banks as $bankData) {
            $createdBanks[] = BloodBank::create($bankData);
        }

        // 3. Seed Blood Stocks corresponding to the 10 Blood Banks (Randomized realistic units)
        $bloodGroups = ['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'];
        
        foreach ($createdBanks as $bank) {
            // Seed 4 to 7 random blood groups for each bank to simulate realistic availability
            $selectedGroups = array_slice($bloodGroups, 0, rand(4, 8));
            shuffle($selectedGroups);

            foreach ($selectedGroups as $group) {
                BloodStock::create([
                    'blood_bank_id' => $bank->id,
                    'blood_group' => $group,
                    'units_available' => rand(2, 35)
                ]);
            }
        }

        // 4. Seed Events in Indian locations
        $events = [
            [
                'title' => 'Dehradun Youth Blood Camp',
                'description' => 'A special donation camp organized in collaboration with local colleges to encourage youth participation. Certificate and donor badge will be provided.',
                'event_date' => now()->addDays(5)->setHour(9)->setMinute(0),
                'location' => 'IMA Community Hall, Rajpur Road',
            ],
            [
                'title' => 'Rotary Mega Delhi Donation Drive',
                'description' => 'Annual Okhla blood donation camp. All healthy citizens are invited to participate. Walk-ins accepted.',
                'event_date' => now()->addDays(12)->setHour(10)->setMinute(0),
                'location' => 'Rotary Center, Okhla Phase 3',
            ],
            [
                'title' => 'Mumbai Parel Blood Camp',
                'description' => 'Help support local emergency stocks at Wadia and KEM hospitals. High demand for O-ve and A+ve groups.',
                'event_date' => now()->addDays(20)->setHour(8)->setMinute(30),
                'location' => 'Wadia Hospital Main Seminar Hall',
            ],
            [
                'title' => 'Bangalore IT Park Drive',
                'description' => 'A corporate social responsibility initiative at Manyata Tech Park. Free health screening for all donors.',
                'event_date' => now()->addDays(8)->setHour(9)->setMinute(30),
                'location' => 'Narayana Health Center, Bommasandra',
            ],
            [
                'title' => 'Chennai Beach Camp',
                'description' => 'Donation camp organized near Marina Beach. Join hands with Apollo Doctors to donate blood and enjoy free juices/breakfast.',
                'event_date' => now()->addDays(15)->setHour(7)->setMinute(0),
                'location' => 'Apollo Health Tent, Marina Beach',
            ],
            [
                'title' => 'Pune Station Camp Drive',
                'description' => 'Blood donation camp to replenish emergency stocks for critical surgeries and road victims.',
                'event_date' => now()->addDays(18)->setHour(10)->setMinute(0),
                'location' => 'Ruby Hall Clinic Campus, Sassoon Road',
            ],
            [
                'title' => 'Kolkata Durga Puja Pre-Camp',
                'description' => 'Special camp before festival season. Ensure critical availability in Woodlands Blood Bank.',
                'event_date' => now()->addDays(25)->setHour(9)->setMinute(0),
                'location' => 'Alipore Woodlands Reception Lounge',
            ],
            [
                'title' => 'Lucknow SGPGI Emergency Camp',
                'description' => 'Urgent camp addressing high demand in critical care wards. Refreshments and certificate of honor will be given.',
                'event_date' => now()->addDays(3)->setHour(8)->setMinute(0),
                'location' => 'SGPGI Blood Center, Raebareli Road',
            ]
        ];

        // Randomly assign bank IDs to the events
        foreach ($events as $index => $eventData) {
            $bankIndex = $index % count($createdBanks);
            $eventData['blood_bank_id'] = $createdBanks[$bankIndex]->id;
            Event::create($eventData);
        }

        // 5. Seed Blood Requests in Indian Cities (10 requests)
        $requests = [
            [
                'requester_name' => 'Ramesh Sharma',
                'blood_group' => 'O+',
                'units_needed' => 2,
                'hospital' => 'Max Super Speciality Hospital',
                'city' => 'Dehradun',
                'urgency' => 'urgent',
                'status' => 'pending',
            ],
            [
                'requester_name' => 'Suman Gupta',
                'blood_group' => 'B+',
                'units_needed' => 3,
                'hospital' => 'AIIMS Hospital',
                'city' => 'Delhi',
                'urgency' => 'normal',
                'status' => 'matched',
            ],
            [
                'requester_name' => 'Vijay Patil',
                'blood_group' => 'A+',
                'units_needed' => 1,
                'hospital' => 'KEM Hospital',
                'city' => 'Mumbai',
                'urgency' => 'urgent',
                'status' => 'fulfilled',
            ],
            [
                'requester_name' => 'Karthik Raja',
                'blood_group' => 'AB-',
                'units_needed' => 2,
                'hospital' => 'Apollo Specialty Hospital',
                'city' => 'Chennai',
                'urgency' => 'urgent',
                'status' => 'pending',
            ],
            [
                'requester_name' => 'Sunita Gowda',
                'blood_group' => 'A-',
                'units_needed' => 4,
                'hospital' => 'Manipal Hospital',
                'city' => 'Bangalore',
                'urgency' => 'urgent',
                'status' => 'pending',
            ],
            [
                'requester_name' => 'Priya Deshmukh',
                'blood_group' => 'O-',
                'units_needed' => 1,
                'hospital' => 'Ruby Hall Clinic',
                'city' => 'Pune',
                'urgency' => 'urgent',
                'status' => 'matched',
            ],
            [
                'requester_name' => 'Joydeb Roy',
                'blood_group' => 'B-',
                'units_needed' => 2,
                'hospital' => 'Woodlands Multispeciality',
                'city' => 'Kolkata',
                'urgency' => 'normal',
                'status' => 'pending',
            ],
            [
                'requester_name' => 'Laxmi Prasad',
                'blood_group' => 'O+',
                'units_needed' => 3,
                'hospital' => 'Yashoda Hospital',
                'city' => 'Hyderabad',
                'urgency' => 'urgent',
                'status' => 'pending',
            ],
            [
                'requester_name' => 'Manish Mehta',
                'blood_group' => 'A+',
                'units_needed' => 5,
                'hospital' => 'Civil Hospital',
                'city' => 'Ahmedabad',
                'urgency' => 'normal',
                'status' => 'fulfilled',
            ],
            [
                'requester_name' => 'Amit Dwivedi',
                'blood_group' => 'AB+',
                'units_needed' => 2,
                'hospital' => 'SGPGI Lucknow',
                'city' => 'Lucknow',
                'urgency' => 'urgent',
                'status' => 'pending',
            ]
        ];

        foreach ($requests as $reqData) {
            BloodRequest::create($reqData);
        }
    }
}
