@extends('layouts.administration.app')

@section('admin_title_content')
    {{config('app.name')}} || Create Prescription
@endsection

@section('admin_content_header')
    <div class="col-sm-6">
        <h1 class="m-0">Create Prescription</h1>
    </div>
    <x-ad-breadcrumb :items="[
        ['label' => 'Dashboard', 'url' => route('dashboard')],
        ['label' => 'Appointments', 'url' => route('administration.appointment.myPatientsAppointments')],
        ['label' => 'Create Prescription'],
    ]" />
@endsection

@section('admin_page_css')
<style>
    .medicine-item {
        background: #f8f9fa;
        padding: 15px;
        margin-bottom: 15px;
        border-radius: 8px;
        border-left: 4px solid var(--bs-primary);
    }
    .remove-medicine {
        color: #dc3545;
        cursor: pointer;
        font-size: 1.2em;
    }
    .remove-medicine:hover {
        color: #c82333;
    }
    .appointment-info {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
    }
</style>
@endsection

@section('main_content')
    <div class="container-fluid">
        <!-- Appointment Information -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card appointment-info">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h5 class="card-title mb-3">
                                    <i class="fas fa-calendar-check me-2"></i>
                                    Appointment Details
                                </h5>
                                @if($appointment && $appointment->patient)
                                    <p class="mb-2"><strong>Patient:</strong> {{ $appointment->patient->name ?? 'N/A' }}</p>
                                @else
                                    <p class="mb-2 text-muted">Patient information not available</p>
                                @endif
                                <p class="mb-2"><strong>Date:</strong>
                                    @if($appointment && $appointment->appointment_date)
                                        {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('M d, Y') }}
                                    @elseif($appointment && $appointment->start_at)
                                        {{ \Carbon\Carbon::parse($appointment->start_at)->format('M d, Y') }}
                                    @else
                                        N/A
                                    @endif
                                </p>
                                @if($appointment && $appointment->start_at && $appointment->end_at)
                                    <p class="mb-2"><strong>Time:</strong> {{ \Carbon\Carbon::parse($appointment->start_at)->format('h:i A') }} - {{ \Carbon\Carbon::parse($appointment->end_at)->format('h:i A') }}</p>
                                @endif
                                @if($appointment && $appointment->reason)
                                    <p class="mb-0"><strong>Reason:</strong> {{ $appointment->reason }}</p>
                                @endif
                            </div>
                            <div class="col-md-6">
                                <h5 class="card-title mb-3">
                                    <i class="fas fa-user-md me-2"></i>
                                    Patient Information
                                </h5>
                                @if($appointment && $appointment->patient)
                                    <p class="mb-2"><strong>Phone:</strong> {{ $appointment->patient->profile->contact_no ?? 'N/A' }}</p>
                                    <p class="mb-2"><strong>Email:</strong> {{ $appointment->patient->email ?? 'N/A' }}</p>
                                    @if($appointment->patient->profile && $appointment->patient->profile->date_of_birth)
                                        <p class="mb-2"><strong>Age:</strong>
                                            {{ \Carbon\Carbon::parse($appointment->patient->profile->date_of_birth)->age }} years
                                        </p>
                                    @endif
                                    @if($appointment->patient->profile && $appointment->patient->profile->blood_group)
                                        <p class="mb-0"><strong>Blood Group:</strong> {{ $appointment->patient->profile->blood_group }}</p>
                                    @endif
                                @else
                                    <p class="mb-2 text-muted">Patient information not available</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <form action="{{ route('administration.prescriptions.store') }}" method="POST" id="prescriptionForm">
            @csrf

            <input type="hidden" name="appointment_id" value="{{ $appointment->id }}">

            <div class="row">
                <!-- Main Prescription Form -->
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-prescription me-2"></i>
                                Prescription Details
                            </h5>
                        </div>
                        <div class="card-body">
                            <!-- Diagnosis -->
                            <div class="mb-3">
                                <label for="diagnosis" class="form-label">Diagnosis <span class="text-danger">*</span></label>
                                <textarea class="form-control" id="diagnosis" name="diagnosis" rows="3"
                                          placeholder="Enter diagnosis..." required>{{ old('diagnosis') }}</textarea>
                                @error('diagnosis')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Medicines Section -->
                            <div class="mb-4">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h6 class="mb-0">Medicines</h6>
                                    <button type="button" class="btn btn-primary btn-sm" id="addMedicine">
                                        <i class="fas fa-plus me-1"></i> Add Medicine
                                    </button>
                                </div>

                                <div id="medicinesContainer">
                                    <div class="medicine-item">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <label class="form-label">Medicine Name <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" name="items[0][medicine_name]" placeholder="Medicine name" required>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="form-label">Dosage <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" name="items[0][dosage]" placeholder="e.g., 500mg" required>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="form-label">Duration <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" name="items[0][duration]" placeholder="e.g., 7 days" required>
                                            </div>
                                            <div class="col-md-3">
                                                <label class="form-label">Frequency <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" name="items[0][frequency]" placeholder="e.g., Twice daily" required>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="form-label">&nbsp;</label>
                                                <button type="button" class="btn btn-outline-danger w-100 remove-medicine" style="display: none;">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @error('items')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Instructions -->
                            <div class="mb-3">
                                <label for="instructions" class="form-label">Instructions</label>
                                <textarea class="form-control" id="instructions" name="instructions" rows="3"
                                          placeholder="Special instructions for the patient...">{{ old('instructions') }}</textarea>
                                @error('instructions')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Additional Notes -->
                            <div class="mb-3">
                                <label for="notes" class="form-label">Additional Notes</label>
                                <textarea class="form-control" id="notes" name="notes" rows="2"
                                          placeholder="Any additional notes...">{{ old('notes') }}</textarea>
                                @error('notes')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="col-lg-4">
                    <!-- Quick Actions -->
                    <div class="card">
                        <div class="card-header">
                            <h6 class="card-title mb-0">
                                <i class="fas fa-bolt me-2"></i>
                                Quick Actions
                            </h6>
                        </div>
                        <div class="card-body">
                            <button type="submit" class="btn btn-success w-100 mb-3">
                                <i class="fas fa-save me-2"></i>Save Prescription
                            </button>
                            <a href="{{ route('administration.appointment.myPatientsAppointments') }}" class="btn btn-secondary w-100 mb-3">
                                <i class="fas fa-arrow-left me-2"></i>Back to Appointments
                            </a>
                            <button type="button" class="btn btn-info w-100" onclick="previewPrescription()">
                                <i class="fas fa-eye me-2"></i>Preview
                            </button>
                        </div>
                    </div>

                    <!-- Common Medicines -->
                    <div class="card mt-3">
                        <div class="card-header">
                            <h6 class="card-title mb-0">
                                <i class="fas fa-pills me-2"></i>
                                Common Medicines
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="d-grid gap-2">
                                <button type="button" class="btn btn-outline-primary btn-sm" onclick="addCommonMedicine('Paracetamol', '500mg', '3 days', 'Twice daily')">
                                    Paracetamol 500mg
                                </button>
                                <button type="button" class="btn btn-outline-primary btn-sm" onclick="addCommonMedicine('Amoxicillin', '250mg', '5 days', 'Three times daily')">
                                    Amoxicillin 250mg
                                </button>
                                <button type="button" class="btn btn-outline-primary btn-sm" onclick="addCommonMedicine('Ibuprofen', '400mg', '3 days', 'As needed for pain')">
                                    Ibuprofen 400mg
                                </button>
                                <button type="button" class="btn btn-outline-primary btn-sm" onclick="addCommonMedicine('Cetirizine', '10mg', '7 days', 'Once daily at night')">
                                    Cetirizine 10mg
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <!-- Medicine Item Template -->
    <div id="medicineTemplate" style="display: none;">
        <div class="medicine-item">
            <div class="row">
                <div class="col-md-3">
                    <label class="form-label">Medicine Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="items[@{{ medicineIndex }}][medicine_name]" placeholder="Medicine name" required>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Dosage <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="items[@{{ medicineIndex }}][dosage]" placeholder="e.g., 500mg" required>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Duration <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="items[@{{ medicineIndex }}][duration]" placeholder="e.g., 7 days" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Frequency <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="items[@{{ medicineIndex }}][frequency]" placeholder="e.g., Twice daily" required>
                </div>
                <div class="col-md-2">
                    <label class="form-label">&nbsp;</label>
                    <button type="button" class="btn btn-outline-danger w-100 remove-medicine">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('admin_page_js')
<script>
let medicineIndex = 1;

$(document).ready(function() {
    // Add medicine
    $('#addMedicine').click(function() {
        addMedicineRow();
    });

    // Remove medicine
    $(document).on('click', '.remove-medicine', function() {
        $(this).closest('.medicine-item').remove();
        updateMedicineIndices();
    });

    // Form validation
    $('#prescriptionForm').submit(function(e) {
        if (!$('#diagnosis').val().trim()) {
            alert('Please enter a diagnosis.');
            e.preventDefault();
            $('#diagnosis').focus();
            return false;
        }

        const medicines = $('input[name*="[medicine_name]"]:visible');
        if (medicines.length === 0 || !medicines.filter(function() { return $(this).val().trim(); }).length) {
            alert('Please add at least one medicine.');
            e.preventDefault();
            return false;
        }
    });
});

function addMedicineRow() {
    const template = $('#medicineTemplate').html().replace(/\{\{medicineIndex\}\}/g, medicineIndex);
    $('#medicinesContainer').append(template);
    medicineIndex++;
    updateRemoveButtons();
}

function updateMedicineIndices() {
    $('#medicinesContainer .medicine-item').each(function(index) {
        $(this).find('input').each(function() {
            const name = $(this).attr('name');
            if (name) {
                const newName = name.replace(/items\[\d+\]/, 'items[' + index + ']');
                $(this).attr('name', newName);
            }
        });
    });
    updateRemoveButtons();
}

function updateRemoveButtons() {
    const medicineItems = $('.medicine-item');
    if (medicineItems.length > 1) {
        $('.remove-medicine').show();
    } else {
        $('.remove-medicine').hide();
    }
}

function addCommonMedicine(name, dosage, duration, frequency) {
    addMedicineRow();
    const lastMedicine = $('.medicine-item:last');
    lastMedicine.find('input[name*="[medicine_name]"]').val(name);
    lastMedicine.find('input[name*="[dosage]"]').val(dosage);
    lastMedicine.find('input[name*="[duration]"]').val(duration);
    lastMedicine.find('input[name*="[frequency]"]').val(frequency);
}

function previewPrescription() {
    // Basic preview functionality - you can expand this
    const diagnosis = $('#diagnosis').val();
    if (!diagnosis.trim()) {
        alert('Please enter a diagnosis first.');
        return;
    }

    alert('Preview functionality would show prescription preview here.');
}
</script>
@endsection