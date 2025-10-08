<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user() !== null;
    }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $user = $this->user();

        $rules = [
            'name' => ['required', 'string', 'max:255'],
        ];

        // Role specific rules
        if ($user && $user->role === 'User') {
            $rules['phone'] = ['required', 'string', 'max:20']; // maps to profile.contact_no
            $rules['position'] = ['required', 'string', 'max:255']; // maps to profile.address
        }

        if ($user && $user->role === 'Doctor') {
            $rules['registration_no'] = ['required', 'string', 'max:255'];
            $rules['specialization'] = ['required', 'string', 'max:255'];
            $rules['hospital_name'] = ['required', 'string', 'max:255'];
            $rules['chamber_address'] = ['required', 'string', 'max:500'];
            $rules['available_time'] = ['required', 'string', 'max:255'];
        }

        if ($user && $user->role === 'Pharmacy') {
            $rules['pharmacy_name'] = ['required', 'string', 'max:255'];
            $rules['owner_name'] = ['required', 'string', 'max:255'];
            $rules['license_number'] = ['required', 'string', 'max:255'];
            $rules['location'] = ['required', 'string', 'max:500'];
            $rules['contact_no'] = ['required', 'string', 'max:20'];
        }

        return $rules;
    }
}
