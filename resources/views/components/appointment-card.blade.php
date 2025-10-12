@props(['appointment'])

<div class="card mb-3 appointment-card">
    <div class="card-header d-flex justify-content-between align-items-center 
        @if($appointment->status === 'pending')
            bg-warning text-dark
        @elseif($appointment->status === 'confirmed')
            bg-success text-white
        @elseif($appointment->status === 'canceled')
            bg-danger text-white
        @else
            bg-info text-white
        @endif">
        <h5 class="mb-0">
            <i class="fas fa-calendar-check me-2"></i>
            Appointment #{{ $appointment->id }}
        </h5>
        <span class="badge bg-light text-dark">
            {{ \Carbon\Carbon::parse($appointment->start_at)->format('M d, Y') }}
        </span>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <h6 class="text-muted mb-1">Doctor</h6>
                <p class="mb-3">
                    <strong>{{ $appointment->doctor->user->name }}</strong><br>
                    <small class="text-muted">{{ $appointment->doctor->specialty }}</small>
                </p>

                <h6 class="text-muted mb-1">Schedule</h6>
                <p class="mb-0">
                    <i class="fas fa-clock text-info me-1"></i>
                    {{ \Carbon\Carbon::parse($appointment->start_at)->format('h:i A') }} - 
                    {{ \Carbon\Carbon::parse($appointment->end_at)->format('h:i A') }}
                </p>
                <p class="mb-3">
                    <i class="fas fa-hourglass-half text-warning me-1"></i>
                    Duration: {{ $appointment->duration ?? \Carbon\Carbon::parse($appointment->end_at)->diffInMinutes(\Carbon\Carbon::parse($appointment->start_at)) }} minutes
                </p>
            </div>
            <div class="col-md-6">
                <h6 class="text-muted mb-1">Patient</h6>
                <p class="mb-3">
                    <strong>{{ $appointment->patient->name }}</strong><br>
                    <small class="text-muted">{{ $appointment->patient->profile->contact_no ?? 'N/A' }}</small>
                </p>

                <h6 class="text-muted mb-1">Status</h6>
                <p class="mb-3">
                    <span class="badge bg-{{ $appointment->status === 'pending' ? 'warning' : ($appointment->status === 'confirmed' ? 'success' : 'danger') }}">
                        {{ ucfirst($appointment->status) }}
                    </span>
                    @if($appointment->status === 'canceled')
                        <small class="text-muted d-block">
                            Canceled by: {{ $appointment->canceled_by }}
                            ({{ \Carbon\Carbon::parse($appointment->canceled_at)->diffForHumans() }})
                        </small>
                    @endif
                </p>
            </div>
        </div>

        @if($appointment->reason)
            <div class="mt-3">
                <h6 class="text-muted mb-1">Reason for Visit</h6>
                <p class="mb-0">{!! $appointment->reason !!}</p>
            </div>
        @endif

        @if($appointment->notes)
            <div class="mt-3">
                <h6 class="text-muted mb-1">Notes</h6>
                <p class="mb-0">{{ $appointment->notes }}</p>
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
                                            
                                            <li>
                                                <a class="dropdown-item text-primary" 
                                                href="{{ asset('storage/appointment_documents/' . $document->file_path) }}" 
                                                target="_blank">
                                                <i class="fas fa-eye me-1"></i> View
                                                </a>
                                            </li>
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
        <div class="mt-3 border-top pt-3">
            @if(auth()->user()->hasRole('Patient'))
                @if($appointment->status === 'pending')
                    <button type="button" class="btn btn-danger btn-sm" onclick="cancelAppointment({{ $appointment->id }})">
                        <i class="fas fa-times me-1"></i> Cancel Appointment
                    </button>
                @endif
            @endif

            @if(auth()->user()->hasRole('Doctor'))
                @if($appointment->status === 'pending')
                    <button type="button" class="btn btn-success btn-sm me-2" onclick="confirmAppointment({{ $appointment->id }})">
                        <i class="fas fa-check me-1"></i> Confirm
                    </button>
                    <button type="button" class="btn btn-danger btn-sm" onclick="rejectAppointment({{ $appointment->id }})">
                        <i class="fas fa-times me-1"></i> Reject
                    </button>
                @elseif($appointment->status === 'confirmed')
                    @php
                        $existingPrescription = \App\Models\Prescription\Prescription::where('appointment_id', $appointment->id)->first();
                    @endphp
                    @if(!$existingPrescription)
                        <a href="{{ route('administration.prescriptions.create', $appointment->id) }}" class="btn btn-primary btn-sm me-2">
                            <i class="fas fa-prescription me-1"></i> Create Prescription
                        </a>
                    @else
                        <a href="{{ route('administration.prescriptions.show', $appointment->id) }}" class="btn btn-info btn-sm me-2">
                            <i class="fas fa-eye me-1"></i> View Prescription
                        </a>
                        <a href="{{ route('administration.prescriptions.pdf', $appointment->id) }}" class="btn btn-outline-primary btn-sm" target="_blank">
                            <i class="fas fa-download me-1"></i> PDF
                        </a>
                    @endif
                @endif
            @endif

            @if(auth()->user()->hasRole('Super Admin'))
                <div class="btn-group">
                    <button type="button" class="btn btn-primary btn-sm" onclick="editAppointment({{ $appointment->id }})">
                        <i class="fas fa-edit me-1"></i> Edit
                    </button>
                    <button type="button" class="btn btn-danger btn-sm" onclick="deleteAppointment({{ $appointment->id }})">
                        <i class="fas fa-trash me-1"></i> Delete
                    </button>
                </div>
            @endif
        </div>
    </div>
</div>