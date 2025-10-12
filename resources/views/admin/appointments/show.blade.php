@extends('layouts.administration.app')
@section('admin_title_content')
    {{config('app.name')}} || Appointment Details
@endsection
@section('admin_meta')
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
                                    <br>
                                    <small class="mb-2 text-muted">Chamber: {{ $appointment->doctor->chamber_address ?? null}}</small>
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
                                    <p><strong>Date:</strong> {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('F j, Y') }}</p>
                                    <p><strong>Time:</strong> {{ \Carbon\Carbon::parse($appointment->start_at)->format('g:i A') }} - 
                                        {{ \Carbon\Carbon::parse($appointment->end_at)->format('g:i A') }}</p>
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
                        <div class="card-header">
                            <h5 class="card-title mb-2">Reason & Notes</h5>
                        </div>
                        <div class="card-body">

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

                    <!-- Prescription Section -->
                    @php
                        $prescription = \App\Models\Prescription\Prescription::where('appointment_id', $appointment->id)->first();
                    @endphp

                    @if($prescription)
                    <div class="card mb-3 border-primary">
                        <div class="card-header bg-primary text-white">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-prescription me-2"></i>
                                Prescription Available
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-8">
                                    <p class="mb-2"><strong>Diagnosis:</strong> {{ $prescription->diagnosis }}</p>
                                    <p class="mb-2"><strong>Medicines:</strong> {{ $prescription->items->count() }} prescribed</p>
                                    <p class="mb-2"><strong>Created:</strong> {{ $prescription->created_at->format('M d, Y \a\t h:i A') }}</p>
                                    @if($prescription->instructions)
                                        <p class="mb-0"><strong>Instructions:</strong> {{ Str::limit($prescription->instructions, 100) }}</p>
                                    @endif
                                </div>
                                <div class="col-md-4 text-end">
                                    <a href="{{ route('administration.prescriptions.show', $appointment->id) }}"
                                       class="btn btn-primary btn-sm me-2">
                                        <i class="fas fa-eye me-1"></i> View Prescription
                                    </a>
                                    <a href="{{ route('administration.prescriptions.pdf', $appointment->id) }}"
                                       class="btn btn-outline-primary btn-sm" target="_blank">
                                        <i class="fas fa-download me-1"></i> Download PDF
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Documents Section -->
                    @if($appointment->documents->count() > 0)
                    <div class="card mb-3">
                        <div class="card-header bg-info text-white">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-file-medical me-2"></i>
                                Uploaded Documents ({{ $appointment->documents->count() }})
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                @foreach($appointment->documents as $document)
                                <div class="col-md-6 mb-3">
                                    <div class="card border-info">
                                        <div class="card-body p-3">
                                            <div class="d-flex justify-content-between align-items-start">
                                                <div class="flex-grow-1">
                                                    <div class="d-flex align-items-center mb-2">
                                                        <i class="fas fa-file-{{ $document->type === 'prescription' ? 'prescription' : ($document->type === 'report' ? 'medical' : 'file-alt') }} me-2 text-info"></i>
                                                        <span class="badge bg-{{ $document->type === 'prescription' ? 'primary' : ($document->type === 'report' ? 'info' : 'secondary') }}">
                                                            {{ ucfirst($document->type) }}
                                                        </span>
                                                    </div>
                                                    <h6 class="mb-1">{{ $document->file_name }}</h6>
                                                    <small class="text-muted">
                                                        Uploaded {{ $document->created_at->format('M d, Y \a\t h:i A') }}
                                                        @if($document->updated_at != $document->created_at)
                                                        <br>Updated {{ $document->updated_at->diffForHumans() }}
                                                        @endif
                                                    </small>
                                                </div>
                                                <div class="dropdown">
                                                    <button class="btn btn-sm btn-outline-info dropdown-toggle" type="button" data-toggle="dropdown">
                                                        <i class="fas fa-ellipsis-v"></i>
                                                    </button>
                                                    <ul class="dropdown-menu" role="menu">
                                                        @can('Appointment Update')
                                                            <li><a class="dropdown-item text-danger" href="#" onclick="deleteDocument({{ $document->id }})">
                                                                <i class="fas fa-trash me-1"></i> Delete
                                                            </a></li>
                                                        @endcan
                                                    </ul>
                                                </div>
                                            </div>

                                            @if(in_array(pathinfo($document->file_path, PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png']))
                                                <!-- Image Preview -->
                                                <div class="mt-2">
                                                    <img src="{{ $document->image_url }}" 
                                                        alt="{{ $document->file_name }}" 
                                                        class="img-thumbnail" 
                                                        style="max-width: 200px; max-height: 150px;">
                                                </div>

                                            @elseif(in_array(pathinfo($document->file_path, PATHINFO_EXTENSION), ['pdf']))
                                                <!-- PDF Preview -->
                                                <div class="mt-2">
                                                    <a href="{{ route('appointments.documents.view', $document->id) }}" 
                                                    target="_blank" 
                                                    class="btn btn-outline-danger btn-sm">
                                                    <i class="fas fa-file-pdf me-1"></i> View PDF
                                                    </a>
                                                </div>

                                            @elseif(in_array(pathinfo($document->file_path, PATHINFO_EXTENSION), ['doc', 'docx']))
                                                <!-- Word Document -->
                                                <div class="mt-2">
                                                    <a href="{{ asset('storage/' . $document->file_path) }}" 
                                                    target="_blank" 
                                                    class="btn btn-outline-primary btn-sm">
                                                    <i class="fas fa-file-word me-1"></i> View Word File
                                                    </a>
                                                </div>

                                            @else
                                                <!-- Other File Types -->
                                                <div class="mt-2">
                                                    <a href="{{ asset('storage/' . $document->file_path) }}" 
                                                    target="_blank" 
                                                    class="btn btn-outline-secondary btn-sm">
                                                    <i class="fas fa-file me-1"></i> View File
                                                    </a>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Actions -->
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <a href="{{ route('administration.appointment.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left me-2"></i>Back to List
                                </a>
                                <div>
                                    @can('Appointment Update')
                                        <a href="{{ route('administration.appointment.edit', $appointment->id) }}" 
                                            class="btn btn-primary me-2">
                                            <i class="fas fa-edit me-2"></i>Edit
                                        </a>
                                    @endcan

                                    @can('Appointment Delete')
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
                                    @endcan
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

@section('admin_page_css')
<style>
    .prescription-section {
        border-left: 4px solid var(--bs-primary) !important;
    }
    .prescription-info {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        padding: 1rem;
        border-radius: 8px;
    }
</style>
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

function deleteDocument(documentId) {
    var url = "{{ route('administration.appointment.documents.destroy', ':id') }}";
    url = url.replace(':id', documentId);
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this deletion!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            // Send delete request
            fetch(url, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                },
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Deleted!',
                        text: 'Document has been deleted successfully.'
                    });

                    // Reload page to update the list
                    setTimeout(() => {
                        window.location.reload();
                    }, 1500);
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Delete Failed',
                        text: 'Failed to delete document. Please try again.'
                    });
                }
            })
            .catch(error => {
                Swal.fire({
                    icon: 'error',
                    title: 'Delete Failed',
                    text: 'Failed to delete document. Please try again.'
                });
            });
        }
    });
}
</script>
@endsection