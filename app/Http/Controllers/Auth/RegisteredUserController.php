<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Doctor\Doctor;
use App\Models\Pharmacy\Pharmacy;
use App\Models\User;
use App\Models\UserProfile\UserProfile;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Spatie\Permission\Models\Role;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
    */
    public function create(): View
    {
        $roles = Role::whereNotIn('name', ['admin', 'super admin', 'administration'])->get();
        return view('auth.register', compact('roles'));
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        // Validate base user fields and role
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'string'],
        ]);

        // Parse role from the combined value (id--name)
        $combinedValue = $request->input('role');
        $roleId = null;
        $roleName = null;
        if ($combinedValue && str_contains($combinedValue, '--')) {
            $parts = explode('--', $combinedValue, 2);
            $roleId = $parts[0];
            $roleName = strtolower($parts[1]);
        } else {
            return back()->withErrors(['role' => 'Invalid role selection.']);
        }

        // Dynamic validation based on role
        $roleSpecificRules = [];
        if ($roleName === 'doctor') {
            $roleSpecificRules = [
                'specialty' => ['required', 'string'],
                'qualification' => ['required', 'string'],
                'experience_years' => ['required', 'integer', 'min:0'],
                'license_number' => ['required', 'string', 'unique:doctors,license_number'],
                'consultation_fee' => ['required', 'numeric', 'min:0'],
                'chamber_address' => ['sometimes', 'string', 'nullable'],
                'bio' => ['sometimes', 'string', 'nullable'],
                'available_days' => ['required', 'array', 'min:1'],
                'available_days.*' => ['string', 'in:Sunday,Monday,Tuesday,Wednesday,Thursday,Friday,Saturday'],
                'opening_time' => ['required', 'date_format:H:i'],
                'closing_time' => ['required', 'date_format:H:i'],
                'time_slot_duration' => ['required', 'integer', 'min:15', 'max:120'],
            ];
        } elseif ($roleName === 'pharmacy') {
            $roleSpecificRules = [
                'pharmacy_name' => ['required', 'string'],
                'owner_name' => ['sometimes', 'string', 'nullable'],
                'license_number' => ['required', 'string', 'unique:pharmacies,license_number'],
                'contact_no' => ['required', 'string', 'max:20'],
                'address' => ['required', 'string'],
                'city' => ['required', 'string'],
                'state' => ['required', 'string'],
                'postal_code' => ['required', 'string'],
                'opening_time' => ['required', 'date_format:H:i'],
                'closing_time' => ['required', 'date_format:H:i'],
                'delivery_available' => ['sometimes', 'boolean'],
                'emergency_service' => ['sometimes', 'boolean'],
                'description' => ['sometimes', 'string', 'nullable'],
            ];
        } elseif ($roleName === 'patient') {
            $roleSpecificRules = [
                'contact_no' => ['required', 'string', 'max:20'],
                'address' => ['required', 'string'],
                'city' => ['required', 'string'],
                'state' => ['required', 'string'],
                'postal_code' => ['required', 'string'],
                'country' => ['required', 'string'],
                'date_of_birth' => ['required', 'date'],
                'gender' => ['required', 'string', 'in:male,female,other'],
                'blood_group' => ['required', 'string'],
            ];
        } else {
            $roleSpecificRules = [
                'contact_no' => ['sometimes', 'string', 'max:20'],
                'address' => ['sometimes', 'string'],
                'city' => ['sometimes', 'string'],
                'state' => ['sometimes', 'string'],
                'postal_code' => ['sometimes', 'string'],
                'country' => ['sometimes', 'string'],
                'date_of_birth' => ['sometimes', 'date'],
                'gender' => ['sometimes', 'string', 'in:male,female,other'],
                'blood_group' => ['sometimes', 'string'],
            ];
        }

        $request->validate($roleSpecificRules);

        // Create user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => $roleId,
        ]);
        $user->assignRole($roleName);

        if($roleName === 'patient') {
            // Create basic profile for all users
            $profileData = [
                'user_id' => $user->id,
                'contact_no' => $request->input('contact_no'),
                'address' => $request->input('address'),
                'city' => $request->input('city'),
                'state' => $request->input('state'),
                'country' => $request->input('country'),
                'postal_code' => $request->input('postal_code'),
                'date_of_birth' => $request->input('date_of_birth'),
                'gender' => $request->input('gender'),
                'blood_group' => $request->input('blood_group'),
            ];
            UserProfile::create($profileData);
        }
        // Create role-specific records
        elseif ($roleName === 'doctor') {
            Doctor::create([
                'user_id' => $user->id,
                'specialty' => $request->specialty,
                'qualification' => $request->qualification,
                'experience_years' => $request->experience_years,
                'license_number' => $request->license_number,
                'chamber_address' => $request->input('chamber_address'),
                'consultation_fee' => $request->consultation_fee,
                'bio' => $request->input('bio'),
                'available_days' => json_encode($request->input('available_days', [])),
                'available_time' => json_encode([
                    'opening_time' => $request->opening_time,
                    'closing_time' => $request->closing_time,
                ]),
                'duration' => (string) $request->input('time_slot_duration', 30),
            ]);
        } elseif ($roleName === 'pharmacy') {
            Pharmacy::create([
                'user_id' => $user->id,
                'pharmacy_name' => $request->pharmacy_name,
                'owner_name' => $request->input('owner_name'),
                'license_number' => $request->license_number,
                'contact_no' => $request->contact_no,
                'address' => $request->address,
                'city' => $request->city,
                'state' => $request->state,
                'postal_code' => $request->postal_code,
                'opening_hours' => json_encode([
                    'opening_time' => $request->opening_time,
                    'closing_time' => $request->closing_time,
                ]),
                'delivery_available' => $request->boolean('delivery_available'),
                'emergency_service' => $request->boolean('emergency_service'),
                'description' => $request->input('description'),
            ]);
        }

        event(new Registered($user));
        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}
