<?php

namespace App\Http\Requests\Administration\Appoinment;

use Illuminate\Foundation\Http\FormRequest;

class StoreAppointmentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'doctor_id' => 'required|exists:doctors,id',
            'date' => 'required|date|after_or_equal:today',
            'time_slot' => 'required|json',
            'reason' => 'required|string|min:10|max:500',
            'notes' => 'nullable|string|max:500',
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'doctor_id.required' => 'Please select a doctor',
            'date.required' => 'Please select an appointment date',
            'time_slot.required' => 'Please select an appointment time slot',
            'reason.required' => 'Please provide a reason for the visit',
            'reason.min' => 'The reason for visit must be at least 10 characters',
        ];
    }
}
