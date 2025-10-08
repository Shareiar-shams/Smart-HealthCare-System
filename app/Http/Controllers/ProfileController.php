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
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $user = $request->user();

        $user->save();

        // Persist role specific related data
        // User -> profile (contact_no, address)
        if ($user->role === 'User') {
            $user->profile()->updateOrCreate(
                ['user_id' => $user->id],
                [
                    'contact_no' => $request->input('phone'),
                    'address' => $request->input('position'),
                ]
            );
        }

        // Doctor -> doctor table (registration_no, specialization, hospital_name, chamber_address, available_time)
        if ($user->role === 'Doctor') {
            $user->doctor()->updateOrCreate(
                ['user_id' => $user->id],
                [
                    'registration_no' => $request->input('registration_no'),
                    'specialization' => $request->input('specialization'),
                    'hospital_name' => $request->input('hospital_name'),
                    'chamber_address' => $request->input('chamber_address'),
                    'available_time' => $request->input('available_time'),
                ]
            );
        }

        // Pharmacy -> pharmacy table (pharmacy_name, owner_name, license_number, location, contact_no)
        if ($user->role === 'Pharmacy') {
            $user->pharmacy()->updateOrCreate(
                ['user_id' => $user->id],
                [
                    'pharmacy_name' => $request->input('pharmacy_name'),
                    'owner_name' => $request->input('owner_name'),
                    'license_number' => $request->input('license_number'),
                    'location' => $request->input('location'),
                    'contact_no' => $request->input('contact_no'),
                ]
            );
        }

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
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
