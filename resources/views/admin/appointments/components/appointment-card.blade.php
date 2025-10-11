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
                <p class="mb-0">{{ $appointment->reason }}</p>
            </div>
        @endif

        @if($appointment->notes)
            <div class="mt-3">
                <h6 class="text-muted mb-1">Notes</h6>
                <p class="mb-0">{{ $appointment->notes }}</p>
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