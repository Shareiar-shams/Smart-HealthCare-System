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

        // Update common profile fields for all users
        $user->profile()->updateOrCreate(
            ['user_id' => $user->id],
            [
                'contact_no' => $request->input('phone'),
                'address' => $request->input('address'),
                'city' => $request->input('city'),
                'state' => $request->input('state'),
                'postal_code' => $request->input('postal_code'),
                'gender' => $request->input('gender'),
                'blood_group' => $request->input('blood_group'),
            ]
        );

        // Update role-specific related data
        if ($user->role === 'doctor') {
            $user->doctor()->updateOrCreate(
                ['user_id' => $user->id],
                [
                    'specialty' => $request->input('specialty'),
                    'qualification' => $request->input('qualification'),
                    'experience_years' => $request->input('experience_years'),
                    'license_number' => $request->input('license_number'),
                    'consultation_fee' => $request->input('consultation_fee'),
                    'bio' => $request->input('bio'),
                ]
            );
        }

        if ($user->role === 'pharmacy') {
            $user->pharmacy()->updateOrCreate(
                ['user_id' => $user->id],
                [
                    'pharmacy_name' => $request->input('pharmacy_name'),
                    'license_number' => $request->input('license_number'),
                    'delivery_available' => $request->boolean('delivery_available'),
                    'emergency_service' => $request->boolean('emergency_service'),
                    'description' => $request->input('description'),
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
