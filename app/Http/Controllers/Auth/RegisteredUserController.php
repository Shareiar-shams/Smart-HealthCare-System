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
        $roles = Role::whereNotIn('name', ['admin', 'administration', 'patient'])->get();
        return view('auth.register', compact('roles'));
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'string'],
            // Common profile fields
            'phone' => ['sometimes', 'string', 'max:20'],
            'address' => ['sometimes', 'string'],
            'gender' => ['sometimes', 'string', 'in:male,female,other'],
            'blood_group' => ['sometimes', 'string'],
            // Doctor specific fields
            'specialty' => ['required_if:role,*--doctor', 'string'],
            'qualification' => ['required_if:role,*--doctor', 'string'],
            'experience_years' => ['required_if:role,*--doctor', 'integer', 'min:0'],
            'license_number' => ['required_if:role,*--doctor', 'string', 'unique:doctors,license_number'],
            'consultation_fee' => ['required_if:role,*--doctor', 'numeric', 'min:0'],
            'bio' => ['sometimes', 'string'],
            // Pharmacy specific fields
            'pharmacy_name' => ['required_if:role,*--pharmacy', 'string'],
            'city' => ['required_if:role,*--pharmacy', 'string'],
            'state' => ['required_if:role,*--pharmacy', 'string'],
            'postal_code' => ['required_if:role,*--pharmacy', 'string'],
            'delivery_available' => ['sometimes', 'boolean'],
            'emergency_service' => ['sometimes', 'boolean'],
            'description' => ['sometimes', 'string'],
        ]);

        // 1. Get the combined value from the request
        $combinedValue = $request->input('role');
        $roleId = null;
        $roleName = null;
        // 2. Check if the value exists and contains the separator
        if ($combinedValue && str_contains($combinedValue, '--')) {
            
            // 3. Explode the string using the separator ('--')
            $parts = explode('--', $combinedValue, 2); 
            
            // 4. Assign the separated values
            $roleId = $parts[0];
            $roleName = strtolower($parts[1]);
        } else {
            // Handle the case where the value is not in the expected format
            return back()->withErrors(['role' => 'Invalid role selection.']);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => $roleId,
        ]);
        $user->assignRole($roleName);

        // Create basic profile for all users
        $profileData = [
            'user_id' => $user->id,
            'contact_no' => $request->phone,
            'address' => $request->address,
            'gender' => $request->gender,
            'blood_group' => $request->blood_group,
            'city' => $request->city,
            'state' => $request->state,
            'postal_code' => $request->postal_code,
        ];

        switch ($roleName) {
            case 'doctor':
                UserProfile::create($profileData);
                Doctor::create([
                    'user_id' => $user->id,
                    'specialty' => $request->specialty,
                    'qualification' => $request->qualification,
                    'experience_years' => $request->experience_years,
                    'license_number' => $request->license_number,
                    'consultation_fee' => $request->consultation_fee,
                    'bio' => $request->bio,
                    'available_days' => json_encode(['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday']), // Default value
                    'available_time' => json_encode(['morning' => '09:00-13:00', 'evening' => '17:00-21:00']), // Default value
                ]);
                break;

            case 'pharmacy':
                UserProfile::create($profileData);
                Pharmacy::create([
                    'user_id' => $user->id,
                    'pharmacy_name' => $request->pharmacy_name,
                    'license_number' => $request->license_number,
                    'contact_no' => $request->phone,
                    'address' => $request->address,
                    'city' => $request->city,
                    'state' => $request->state,
                    'postal_code' => $request->postal_code,
                    'opening_hours' => json_encode([
                        'weekdays' => '09:00-21:00',
                        'weekends' => '10:00-18:00'
                    ]),
                    'delivery_available' => $request->boolean('delivery_available'),
                    'emergency_service' => $request->boolean('emergency_service'),
                    'description' => $request->description,
                ]);
                break;

            case 'user':
            case 'patient':
            default:
                UserProfile::create($profileData);
                break;
            
        }

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}
