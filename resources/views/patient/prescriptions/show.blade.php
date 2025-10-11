@extends('layouts.administration.app')

@section('admin_title_content')
    {{config('app.name')}} || Prescription Details
@endsection

@section('admin_content_header')
    <div class="col-sm-6">
        <h1 class="m-0">Prescription Details</h1>
    </div>
    <x-ad-breadcrumb :items="[
        ['label' => 'Dashboard', 'url' => route('dashboard')],
        ['label' => 'My Prescriptions', 'url' => route('patient.prescriptions')],
        ['label' => 'View Prescription'],
    ]" />
@endsection

@section('admin_page_css')
<style>
    .prescription-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 2rem;
        margin-bottom: 2rem;
        border-radius: 10px;
    }
    .medicine-card {
        background: #f8f9fa;
        border-left: 4px solid var(--bs-primary);
        padding: 1rem;
        margin-bottom: 1rem;
        border-radius: 8px;
    }
    .prescription-info {
        background: #e9ecef;
        padding: 1rem;
        border-radius: 8px;
        margin-bottom: 1rem;
    }
    .doctor-signature {
        border-top: 2px solid #007bff;
        padding-top: 1rem;
        margin-top: 2rem;
    }
    .print-btn {
        position: fixed;
        bottom: 20px;
        right: 20px;
        z-index: 1000;
        border-radius: 50%;
        width: 60px;
        height: 60px;
        box-shadow: 0 4px 8px rgba(0,0,0,0.2);
    }
</style>
@endsection

@section('main_content')
    <div class="container-fluid">
        <!-- Prescription Header -->
        <div class="prescription-header">
            <div class="row">
                <div class="col-md-6">
                    <h2 class="mb-3">
                        <i class="fas fa-prescription me-2"></i>
                        Prescription #{{ $prescription->id }}
                    </h2>
                    <p class="mb-2">
                        <i class="fas fa-calendar me-2"></i>
                        Date: {{ $prescription->created_at->format('F d, Y') }}
                    </p>
                    <p class="mb-0">
                        <i class="fas fa-clock me-2"></i>
                        Time: {{ $prescription->created_at->format('h:i A') }}
                    </p>
                </div>
                <div class="col-md-6 text-md-end">
                    <h4>{{ config('app.name') }}</h4>
                    <p class="mb-1">Healthcare Management System</p>
                    <p class="mb-0">
                        <i class="fas fa-phone me-1"></i>
                        +1 (555) 123-4567
                    </p>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Patient Information -->
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-user me-2"></i>
                            Patient Information
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="prescription-info">
                            <h6 class="mb-3">Personal Details</h6>
                            <p class="mb-2"><strong>Name:</strong> {{ $prescription->patient->name }}</p>
                            <p class="mb-2"><strong>Email:</strong> {{ $prescription->patient->email }}</p>
                            <p class="mb-2"><strong>Phone:</strong> {{ $prescription->patient->profile->contact_no ?? 'N/A' }}</p>
                            @if($prescription->patient->profile->date_of_birth)
                                <p class="mb-2"><strong>Age:</strong> {{ \Carbon\Carbon::parse($prescription->patient->profile->date_of_birth)->age }} years</p>
                            @endif
                            @if($prescription->patient->profile->blood_group)
                                <p class="mb-0"><strong>Blood Group:</strong> {{ $prescription->patient->profile->blood_group }}</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Doctor Information -->
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-success text-white">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-user-md me-2"></i>
                            Doctor Information
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="prescription-info">
                            <h6 class="mb-3">Medical Professional</h6>
                            <p class="mb-2"><strong>Name:</strong> Dr. {{ $prescription->doctor->user->name }}</p>
                            <p class="mb-2"><strong>Specialty:</strong> {{ $prescription->doctor->specialty ?? 'General Medicine' }}</p>
                            @if($prescription->doctor->qualification)
                                <p class="mb-2"><strong>Qualification:</strong> {{ $prescription->doctor->qualification }}</p>
                            @endif
                            @if($prescription->doctor->license_number)
                                <p class="mb-0"><strong>License:</strong> {{ $prescription->doctor->license_number }}</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Appointment Information -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-info text-white">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-calendar-check me-2"></i>
                            Appointment Information
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <p class="mb-2"><strong>Appointment ID:</strong> #{{ $prescription->appointment_id }}</p>
                                <p class="mb-2"><strong>Date:</strong>
                                    {{ $prescription->appointment->appointment_date ?
                                       \Carbon\Carbon::parse($prescription->appointment->appointment_date)->format('M d, Y') :
                                       \Carbon\Carbon::parse($prescription->appointment->start_at)->format('M d, Y') }}
                                </p>
                            </div>
                            <div class="col-md-6">
                                <p class="mb-2"><strong>Time:</strong>
                                    {{ \Carbon\Carbon::parse($prescription->appointment->start_at)->format('h:i A') }} -
                                    {{ \Carbon\Carbon::parse($prescription->appointment->end_at)->format('h:i A') }}
                                </p>
                                @if($prescription->appointment->reason)
                                    <p class="mb-0"><strong>Reason for Visit:</strong> {{ $prescription->appointment->reason }}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Diagnosis -->
        @if($prescription->diagnosis)
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header bg-warning text-dark">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-stethoscope me-2"></i>
                                Diagnosis
                            </h5>
                        </div>
                        <div class="card-body">
                            <p class="lead">{{ $prescription->diagnosis }}</p>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Medicines -->
        @if($prescription->items && $prescription->items->count() > 0)
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header bg-primary text-white">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-pills me-2"></i>
                                Prescribed Medicines
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                @foreach($prescription->items as $item)
                                    <div class="col-md-6 mb-3">
                                        <div class="medicine-card">
                                            <h6 class="mb-2">{{ $item->medicine_name }}</h6>
                                            <div class="row text-sm">
                                                <div class="col-6">
                                                    <strong>Dosage:</strong><br>
                                                    {{ $item->dosage }}
                                                </div>
                                                <div class="col-6">
                                                    <strong>Duration:</strong><br>
                                                    {{ $item->duration }}
                                                </div>
                                            </div>
                                            <div class="mt-2">
                                                <strong>Frequency:</strong> {{ $item->frequency }}
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Instructions and Notes -->
        <div class="row mb-4">
            <div class="col-md-6">
                @if($prescription->instructions)
                    <div class="card">
                        <div class="card-header bg-info text-white">
                            <h6 class="card-title mb-0">
                                <i class="fas fa-exclamation-circle me-2"></i>
                                Instructions
                            </h6>
                        </div>
                        <div class="card-body">
                            <p>{{ $prescription->instructions }}</p>
                        </div>
                    </div>
                @endif
            </div>
            <div class="col-md-6">
                @if($prescription->notes)
                    <div class="card">
                        <div class="card-header bg-secondary text-white">
                            <h6 class="card-title mb-0">
                                <i class="fas fa-sticky-note me-2"></i>
                                Additional Notes
                            </h6>
                        </div>
                        <div class="card-body">
                            <p>{{ $prescription->notes }}</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Doctor Signature -->
        <div class="row">
            <div class="col-12">
                <div class="doctor-signature text-center">
                    <p class="mb-2">Prescribed by:</p>
                    <h5 class="mb-1">Dr. {{ $prescription->doctor->user->name }}</h5>
                    <p class="mb-2">{{ $prescription->doctor->specialty ?? 'General Medicine' }}</p>
                    <p class="mb-0">Date: {{ $prescription->created_at->format('F d, Y') }}</p>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="row mt-4">
            <div class="col-12 text-center">
                <a href="{{ route('administration.prescriptions.pdf', $prescription->appointment_id) }}"
                   class="btn btn-primary btn-lg me-3" target="_blank">
                    <i class="fas fa-download me-2"></i>Download PDF
                </a>
                <button onclick="window.print()" class="btn btn-secondary btn-lg me-3">
                    <i class="fas fa-print me-2"></i>Print
                </button>
                <a href="{{ route('patient.prescriptions') }}" class="btn btn-outline-primary btn-lg">
                    <i class="fas fa-arrow-left me-2"></i>Back to Prescriptions
                </a>
            </div>
        </div>
    </div>

    <!-- Print Button -->
    <button onclick="window.print()" class="btn btn-primary print-btn" title="Print Prescription">
        <i class="fas fa-print"></i>
    </button>
@endsection

@section('admin_page_js')
<script>
$(document).ready(function() {
    // Print styles
    if (window.matchMedia) {
        var mediaQueryList = window.matchMedia('print');
        mediaQueryList.addListener(function(mql) {
            if (mql.matches) {
                $('.print-btn').hide();
                $('body').addClass('printing');
            } else {
                $('.print-btn').show();
                $('body').removeClass('printing');
            }
        });
    }
});
</script>
@endsection