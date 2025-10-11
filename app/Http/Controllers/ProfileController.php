<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        $user = Auth::user();
        $activities = $user->activities()->latest()->get()->take(10);
        return view('admin.profile.index', [
            'activities' => $activities,
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();

        // Only update allowed user attributes (exclude email/password)
        $user->name = $request->input('name');
        $user->save();

        // Determine role name (support spatie roles and direct relation)
        $roleName = $user->role->name ?? ($user->getRoleNames()->first() ?? null);
        $roleNameLower = $roleName ? strtolower($roleName) : '';

        // Update role-specific related data
        if ($roleNameLower === 'doctor') {
            $availableDays = $request->input('available_days', []);
            $opening = $request->input('opening_time');
            $closing = $request->input('closing_time');
            $duration = $request->input('time_slot_duration');

            $user->doctor()->updateOrCreate(
                ['user_id' => $user->id],
                [
                    'specialty' => $request->input('specialty'),
                    'qualification' => $request->input('qualification'),
                    'experience_years' => $request->input('experience_years'),
                    'license_number' => $request->input('license_number'),
                    'chamber_address' => $request->input('chamber_address'),
                    'consultation_fee' => $request->input('consultation_fee'),
                    'bio' => $request->input('bio'),
                    'available_days' => json_encode($availableDays),
                    'available_time' => json_encode([
                        'opening_time' => $opening,
                        'closing_time' => $closing,
                    ]),
                    'duration' => $duration !== null ? (string) $duration : null,
                ]
            );
        } elseif ($roleNameLower === 'pharmacy') {
            $opening = $request->input('opening_time');
            $closing = $request->input('closing_time');

            $user->pharmacy()->updateOrCreate(
                ['user_id' => $user->id],
                [
                    'pharmacy_name' => $request->input('pharmacy_name'),
                    'owner_name' => $request->input('owner_name'),
                    'license_number' => $request->input('license_number'),
                    'contact_no' => $request->input('pharmacy_contact_no'),
                    'address' => $request->input('pharmacy_address'),
                    'city' => $request->input('pharmacy_city'),
                    'state' => $request->input('pharmacy_state'),
                    'postal_code' => $request->input('pharmacy_postal_code'),
                    'opening_hours' => json_encode([
                        'opening_time' => $opening,
                        'closing_time' => $closing,
                    ]),
                    'delivery_available' => $request->boolean('delivery_available'),
                    'emergency_service' => $request->boolean('emergency_service'),
                    'description' => $request->input('description'),
                ]
            );
        } elseif ($roleNameLower === 'patient') {
            // Update common profile fields for all users
            $user->profile()->updateOrCreate(
                ['user_id' => $user->id],
                [
                    'contact_no' => $request->input('contact_no'),
                    'address' => $request->input('address'),
                    'city' => $request->input('city'),
                    'state' => $request->input('state'),
                    'country' => $request->input('country'),
                    'postal_code' => $request->input('postal_code'),
                    'date_of_birth' => $request->input('date_of_birth'),
                    'gender' => $request->input('gender'),
                    'blood_group' => $request->input('blood_group'),
                ]
            );
        }
        $notifications = array(
            'message' => 'Profile updated successfully!',
            'alert-type' => 'success'
        );
        return Redirect::route('profile.edit')->with($notifications);
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
