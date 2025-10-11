<?php

namespace App\Http\Controllers\Viewport;

use App\Http\Controllers\Controller;
use App\Models\Viewport\BloodRequest\BloodRequest;
use App\Models\Viewport\Donor\Donor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BloodDonationController extends Controller
{
    public function index()
    {
        $stats = $this->getLiveStats();
        
        return view('viewport.bloodDonation.index', [
            'divisions' => $this->getDivisions(),
            'bloodGroups' => $this->getBloodGroups(),
            'stats' => $stats,
            'divisionStats' => $this->getDivisionStats(),
            'bloodGroupStats' => $this->getBloodGroupStats()
        ]);
    }

    public function registerDonor(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:donors,email',
            'phone' => 'required|string|max:15|unique:donors,phone',
            'blood_group' => 'required|in:A+,A-,B+,B-,AB+,AB-,O+,O-',
            'division' => 'required|string',
            'district' => 'required|string|max:255',
            'last_donation' => 'nullable|date',
            'health_conditions' => 'nullable|string',
            'availability' => 'required|boolean'
        ]);

        $donor = Donor::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Thank you for registering as a blood donor! You will be notified when someone needs your blood type.',
            'donor_id' => $donor->id,
            'matched_requests' => $this->checkImmediateMatches($donor)
        ]);
    }

    public function requestBlood(Request $request)
    {
        $validated = $request->validate([
            'patient_name' => 'required|string|max:255',
            'contact_person' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
            'hospital' => 'required|string|max:255',
            'blood_group' => 'required|in:A+,A-,B+,B-,AB+,AB-,O+,O-',
            'units_required' => 'required|integer|min:1|max:10',
            'urgency' => 'required|in:low,medium,high,critical',
            'division' => 'required|string',
            'district' => 'required|string|max:255',
            'required_date' => 'required|date',
            'gratitude_fee' => 'required|numeric|min:0',
            'additional_info' => 'nullable|string'
        ]);

        $bloodRequest = BloodRequest::create($validated);
        
        $matchedDonors = Donor::where('blood_group', $bloodRequest->blood_group)
                    ->where('division', $bloodRequest->division)
                    ->where('availability', true)
                    ->where('is_verified', true)
                    ->get();
                    
        $matchCount = $matchedDonors->count();

        return response()->json([
            'success' => true,
            'message' => 'Blood request submitted successfully!',
            'request_id' => $bloodRequest->id,
            'matched_donors' => $matchCount,
            'donors' => $matchedDonors->take(5)
        ]);
    }

    public function searchDonors(Request $request)
    {
        $validated = $request->validate([
            'division' => 'nullable|string',
            'blood_group' => 'nullable|in:A+,A-,B+,B-,AB+,AB-,O+,O-',
            'max_gratitude_fee' => 'nullable|numeric|min:0'
        ]);

        try {
            $query = Donor::where('availability', true)
                         ->where('is_verified', true);

            if (!empty($validated['division'])) {
                $query->where('division', $validated['division']);
            }

            if (!empty($validated['blood_group'])) {
                $query->where('blood_group', $validated['blood_group']);
            }

            $donors = $query->select([
                'id', 'name', 'email', 'phone', 'blood_group', 'division', 'district',
                'last_donation', 'availability', 'is_verified'
            ])->get();

            return response()->json([
                'success' => true,
                'donors' => $donors
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error searching donors.'
            ], 500);
        }
    }

    public function getStats()
    {
        return response()->json([
            'total_donors' => Donor::count(),
            'active_donors' => Donor::where('availability', true)->where('is_verified', true)->count(),
            'blood_requests' => BloodRequest::where('status', 'fulfilled')->count(),
            'lives_saved' => BloodRequest::where('status', 'fulfilled')->sum('units_required') * 3,
            'divisions' => $this->getDivisionStats(),
            'blood_groups' => $this->getBloodGroupStats()
        ]);
    }

    private function getLiveStats()
    {
        return [
            'total_donors' => Donor::count(),
            'active_donors' => Donor::where('availability', true)->where('is_verified', true)->count(),
            'blood_requests' => BloodRequest::where('status', 'fulfilled')->count(),
            'lives_saved' => BloodRequest::where('status', 'fulfilled')->sum('units_required') * 3
        ];
    }

    private function getDivisionStats()
    {
        return Donor::select('division', DB::raw('count(*) as count'))
                    ->where('is_verified', true)
                    ->groupBy('division')
                    ->pluck('count', 'division')
                    ->toArray();
    }

    private function getBloodGroupStats()
    {
        return Donor::select('blood_group', DB::raw('count(*) as count'))
                    ->where('is_verified', true)
                    ->where('availability', true)
                    ->groupBy('blood_group')
                    ->pluck('count', 'blood_group')
                    ->toArray();
    }

    private function checkImmediateMatches(Donor $donor)
    {
        return BloodRequest::where('blood_group', $donor->blood_group)
                          ->where('division', $donor->division)
                          ->where('status', 'pending')
                          ->count();
    }

    private function getDivisions()
    {
        return [
            'dhaka' => 'Dhaka',
            'chattogram' => 'Chattogram', 
            'rajshahi' => 'Rajshahi',
            'khulna' => 'Khulna',
            'barishal' => 'Barishal',
            'sylhet' => 'Sylhet',
            'rangpur' => 'Rangpur',
            'mymensingh' => 'Mymensingh'
        ];
    }

    private function getBloodGroups()
    {
        return ['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'];
    }
}