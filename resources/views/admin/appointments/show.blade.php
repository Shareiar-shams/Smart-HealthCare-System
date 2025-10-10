@extends('layouts.administration.app')
@section('admin_title_content')
    Smart HealthCare | Appointment Details
@endsection
@section('admin_content_header')
    <div class="col-sm-6">
        <h1 class="m-0">{{__('Appointment Details')}}</h1>
    </div>
    <x-ad-breadcrumb :items="[
        ['label' => 'Dashboard', 'url' => route('dashboard')],
        ['label' => 'Appointments', 'url' => route('administration.appointment.index')],
        ['label' => 'Details'],
    ]" />
@endsection

@section('main_content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Appointment Information</h3>
                    <div class="card-tools">
                        <span class="badge bg-{{ $appointment->status_color }}">
                            {{ ucfirst($appointment->status) }}
                        </span>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Doctor Information -->
                    <div class="card mb-3">
                        <div class="card-body">
                            <h5 class="card-title">Doctor Information</h5>
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <div class="doctor-avatar">
                                        {{ strtoupper(substr($appointment->doctor->user->name, 0, 2)) }}
                                    </div>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h5 class="mb-1">Dr. {{ $appointment->doctor->user->name }}</h5>
                                    <p class="mb-0">{{ $appointment->doctor->specialty }}</p>
                                    <small class="text-muted">
                                        <i class="fas fa-star text-warning"></i>
                                        Experience: {{ $appointment->doctor->experience_years }} years
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Appointment Details -->
                    <div class="card mb-3">
                        <div class="card-body">
                            <h5 class="card-title">Appointment Details</h5>
                            <div class="row">
                                <div class="col-md-6">
                                    <p><strong>Date:</strong> {{ Carbon::parse($appointment->date)->format('F j, Y') }}</p>
                                    <p><strong>Time:</strong> {{ Carbon::parse($appointment->time_start)->format('g:i A') }} - 
                                        {{ Carbon::parse($appointment->time_end)->format('g:i A') }}</p>
                                    <p><strong>Consultation Fee:</strong> ${{ number_format($appointment->doctor->consultation_fee, 2) }}</p>
                                </div>
                                <div class="col-md-6">
                                    <p><strong>Booking Date:</strong> {{ $appointment->created_at->format('F j, Y') }}</p>
                                    <p><strong>Last Updated:</strong> {{ $appointment->updated_at->diffForHumans() }}</p>
                                    <p><strong>Reference ID:</strong> #{{ $appointment->reference_id }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Reason and Notes -->
                    <div class="card mb-3">
                        <div class="card-body">
                            <h5 class="card-title">Reason & Notes</h5>
                            <div class="mb-3">
                                <strong>Reason for Visit:</strong>
                                <p class="mt-2">{{ $appointment->reason }}</p>
                            </div>
                            @if($appointment->notes)
                            <div>
                                <strong>Additional Notes:</strong>
                                <p class="mt-2">{{ $appointment->notes }}</p>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <a href="{{ route('administration.appointment.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left me-2"></i>Back to List
                                </a>
                                <div>
                                    @if($appointment->canBeEdited())
                                    <a href="{{ route('administration.appointment.edit', $appointment->id) }}" 
                                        class="btn btn-primary me-2">
                                        <i class="fas fa-edit me-2"></i>Edit
                                    </a>
                                    @endif

                                    @if($appointment->canBeCancelled())
                                    <button type="button" class="btn btn-danger" 
                                        onclick="confirmCancellation()">
                                        <i class="fas fa-times-circle me-2"></i>Cancel Appointment
                                    </button>

                                    <form id="cancellation-form" 
                                        action="{{ route('administration.appointment.destroy', $appointment->id) }}" 
                                        method="POST" style="display: none;">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('admin_page_js')
<script>
function confirmCancellation() {
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this cancellation!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, cancel it!'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('cancellation-form').submit();
        }
    });
}
</script>
@endsection