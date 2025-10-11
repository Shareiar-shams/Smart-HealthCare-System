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

        // Base rule: editable name only (explicitly excluding email/password)
        $rules = [
            'name' => ['required', 'string', 'max:255'],
        ];

        // Common profile fields for all roles
        $rules = array_merge($rules, [
            'contact_no' => ['sometimes', 'string', 'max:20'],
            'address' => ['sometimes', 'string'],
            'city' => ['sometimes', 'string'],
            'state' => ['sometimes', 'string'],
            'country' => ['sometimes', 'string'],
            'postal_code' => ['sometimes', 'string'],
            'date_of_birth' => ['sometimes', 'date'],
            'gender' => ['sometimes', 'string', 'in:male,female,other'],
            'blood_group' => ['sometimes', 'string'],
        ]);

        // Role specific rules
        $roleName = $user?->role?->name ?? optional($user?->roles?->first())->name;
        $roleNameLower = $roleName ? strtolower($roleName) : '';

        if ($roleNameLower === 'doctor') {
            $rules = array_merge($rules, [
                'specialty' => ['sometimes', 'string'],
                'qualification' => ['sometimes', 'string'],
                'experience_years' => ['sometimes', 'integer', 'min:0'],
                'license_number' => ['sometimes', 'string', Rule::unique('doctors', 'license_number')->ignore(optional($user?->doctor)->id)],
                'chamber_address' => ['sometimes', 'string', 'nullable'],
                'consultation_fee' => ['sometimes', 'numeric', 'min:0'],
                'bio' => ['sometimes', 'string', 'nullable'],
                'available_days' => ['sometimes', 'array'],
                'available_days.*' => ['string', 'in:Sunday,Monday,Tuesday,Wednesday,Thursday,Friday,Saturday'],
                'opening_time' => ['sometimes', 'date_format:H:i'],
                'closing_time' => ['sometimes', 'date_format:H:i'],
                'time_slot_duration' => ['sometimes', 'integer', 'min:15', 'max:120'],
            ]);
        }

        if ($roleNameLower === 'pharmacy') {
            $rules = array_merge($rules, [
                'pharmacy_name' => ['sometimes', 'string'],
                'owner_name' => ['sometimes', 'string', 'nullable'],
                'license_number' => ['sometimes', 'string', Rule::unique('pharmacies', 'license_number')->ignore(optional($user?->pharmacy)->id)],
                'pharmacy_contact_no' => ['sometimes', 'string', 'max:20'],
                'pharmacy_address' => ['sometimes', 'string'],
                'pharmacy_city' => ['sometimes', 'string'],
                'pharmacy_state' => ['sometimes', 'string'],
                'pharmacy_postal_code' => ['sometimes', 'string'],
                'opening_time' => ['sometimes', 'date_format:H:i'],
                'closing_time' => ['sometimes', 'date_format:H:i'],
                'delivery_available' => ['sometimes', 'boolean'],
                'emergency_service' => ['sometimes', 'boolean'],
                'description' => ['sometimes', 'string', 'nullable'],
            ]);
        }

        return $rules;
    }
}
