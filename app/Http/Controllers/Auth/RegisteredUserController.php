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

        switch ($roleName) {
            case 'user':
            case 'patient':
                UserProfile::create([
                    'user_id' => $user->id,
                    'contact_no' => $request->contact_no,
                    'address' => $request->address,
                ]);
                break;

            case 'doctor':
                Doctor::create([
                    'user_id' => $user->id,
                    'registration_no' => $request->registration_no,
                    'specialization' => $request->specialization,
                    'hospital_name' => $request->hospital_name,
                    'chamber_address' => $request->chamber_address,
                    'available_time' => $request->available_time,
                ]);
                break;

            case 'pharmacy':
                Pharmacy::create([
                    'user_id' => $user->id,
                    'pharmacy_name' => $request->pharmacy_name,
                    'owner_name' => $request->owner_name,
                    'license_number' => $request->license_number,
                    'location' => $request->location,
                    'contact_no' => $request->contact_no,
                    'opening_hours' => $request->opening_hours,
                ]);
                break;
            default:
                UserProfile::create([
                    'user_id' => $user->id,
                    'contact_no' => $request->contact_no,
                    'address' => $request->address,
                ]);
                break;
            
        }

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}
