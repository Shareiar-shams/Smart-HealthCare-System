@extends('layouts.administration.app')
@section('admin_title_content')
    Smart HealthCare | Edit Appointment
@endsection
@section('admin_content_header')
    <div class="col-sm-6">
        <h1 class="m-0">{{__('Edit Appointment')}}</h1>
    </div>
    <x-ad-breadcrumb :items="[
        ['label' => 'Dashboard', 'url' => route('dashboard')],
        ['label' => 'Appointments', 'url' => route('administration.appointment.index')],
        ['label' => 'Edit'],
    ]" />
@endsection

@section('admin_page_css')
<style>
    .time-slot {
        cursor: pointer;
        padding: 10px;
        margin: 5px;
        border: 1px solid #dee2e6;
        border-radius: 5px;
        transition: all 0.2s;
    }
    .time-slot:hover {
        background-color: #e9ecef;
    }
    .time-slot.selected {
        background-color: var(--bs-primary);
        color: white;
    }
    .time-slot.unavailable {
        background-color: #f8f9fa;
        color: #adb5bd;
        cursor: not-allowed;
    }
</style>
@endsection

@section('main_content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Update Appointment</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('administration.appointment.update', $appointment->id) }}" method="POST" id="editAppointmentForm">
                        @csrf
                        @method('PUT')

                        <!-- Doctor Information (Read-only) -->
                        <div class="form-group mb-3">
                            <label>Doctor</label>
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-shrink-0">
                                            <div class="doctor-avatar">
                                                {{ strtoupper(substr($appointment->doctor->user->name, 0, 2)) }}
                                            </div>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <h5 class="mb-1">Dr. {{ $appointment->doctor->user->name }}</h5>
                                            <p class="mb-0 text-muted">{{ $appointment->doctor->specialty }}</p>
                                            <small class="text-muted mb-2">
                                                <i class="fas fa-star text-warning"></i>
                                                Experience: {{ $appointment->doctor->experience_years }} years
                                            </small>
                                            <br>
                                            <small class="mb-2 text-muted">Chamber: {{ $doctor->chamber_address ?? null}}</small>
                                        </div>
                                        <div class="text-end">
                                            <strong class="text-primary">
                                                ${{ number_format($appointment->doctor->consultation_fee, 2) }}
                                            </strong>
                                            <small class="d-block text-muted">per visit</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Date Selection -->
                        <div class="form-group mb-3">
                            <label>Appointment Date</label>
                            <input type="date" class="form-control" name="date" id="appointment_date" 
                                value="{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('Y-m-d') }}"
                                min="{{ date('Y-m-d') }}" 
                                max="{{ date('Y-m-d', strtotime('+30 days')) }}"
                                onchange="loadTimeSlots()" required>
                        </div>

                        <!-- Time Slots -->
                        <div class="form-group mb-3">
                            <label>Available Time Slots</label>
                            <div id="timeSlots" class="d-flex flex-wrap">
                                <div class="text-center">
                                    <i class="fas fa-spinner fa-spin"></i> Loading available slots...
                                </div>
                            </div>
                            <input type="hidden" name="time_slot" id="selected_time_slot" 
                                value="{{ json_encode(['start' => $appointment->time_start, 'end' => $appointment->time_end]) }}">
                        </div>

                        <!-- Reason for Visit -->
                        <div class="form-group mb-3">
                            <label>Reason for Visit</label>
                            <textarea class="form-control" name="reason" rows="3" required>{{ $appointment->reason }}</textarea>
                        </div>

                        <!-- Notes -->
                        <div class="form-group mb-3">
                            <label>Additional Notes (Optional)</label>
                            <textarea class="form-control" name="notes" rows="2">{{ $appointment->notes }}</textarea>
                        </div>

                        <div class="form-group d-flex justify-content-between">
                            <a href="{{ route('administration.appointment.myAppointments') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-2"></i>Back
                            </a>
                            <button type="submit" class="btn btn-primary" id="submitBtn">
                                <i class="fas fa-save me-2"></i>Update Appointment
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('admin_page_js')
<script>
function loadTimeSlots() {
    const date = $('#appointment_date').val();
    const doctorId = {{ $appointment->doctor_id }};
    const currentSlot = JSON.parse($('#selected_time_slot').val());

    if (!date || !doctorId) return;

    $('#timeSlots').html('<div class="text-center"><i class="fas fa-spinner fa-spin"></i> Loading available slots...</div>');

    $.get(`/api/doctor/${doctorId}/time-slots`, { 
        date: date,
        current_appointment_id: {{ $appointment->id }}
    }, function(response) {
        let slotsHtml = '';
        if (response.slots.length > 0) {
            response.slots.forEach(slot => {
                const isCurrentSlot = slot.start === currentSlot.start && slot.end === currentSlot.end;
                slotsHtml += `
                    <div class="time-slot ${slot.available || isCurrentSlot ? '' : 'unavailable'} 
                                        ${isCurrentSlot ? 'selected' : ''}"
                        onclick="${slot.available || isCurrentSlot ? `selectTimeSlot('${slot.start}', '${slot.end}')` : ''}"
                        data-start="${slot.start}" data-end="${slot.end}">
                        ${slot.formatted_time}
                    </div>`;
            });
        } else {
            slotsHtml = '<p class="text-muted">No available slots for selected date</p>';
        }
        $('#timeSlots').html(slotsHtml);
    });
}

function selectTimeSlot(start, end) {
    $('.time-slot').removeClass('selected');
    $(`[data-start="${start}"]`).addClass('selected');
    $('#selected_time_slot').val(JSON.stringify({start, end}));
}

function validateForm() {
    const isValid = $('#appointment_date').val() && 
                   $('#selected_time_slot').val() &&
                   $('textarea[name="reason"]').val();
    
    $('#submitBtn').prop('disabled', !isValid);
}

$(document).ready(function() {
    // Load initial time slots
    loadTimeSlots();

    // Form validation
    $('textarea[name="reason"]').on('input', validateForm);
    $('#appointment_date').on('change', validateForm);

    // Form submission
    $('#editAppointmentForm').on('submit', function(e) {
        if (!validateForm()) {
            e.preventDefault();
            alert('Please fill in all required fields');
        }
    });
});
</script>
@endsection