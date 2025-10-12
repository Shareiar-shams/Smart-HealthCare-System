<!-- Doctor Dashboard Content -->
<div class="row">
    <!-- Doctor Statistics -->
    <div class="col-lg-3 col-6">
        <div class="dashboard-card card gradient-success text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="card-title">My Appointments</h6>
                        <h2 class="mb-0 stat-number" data-count="{{ \App\Models\Appointment\Appointment::where('doctor_id', auth()->user()->doctor->id)->count() }}">
                            {{ \App\Models\Appointment\Appointment::where('doctor_id', auth()->user()->doctor->id)->count() }}
                        </h2>
                        <small>Total appointments</small>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-calendar-check stat-icon"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-6">
        <div class="dashboard-card card gradient-primary text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="card-title">Today's Schedule</h6>
                        <h2 class="mb-0 stat-number" data-count="{{ \App\Models\Appointment\Appointment::where('doctor_id', auth()->user()->doctor->id)->whereDate('start_at', today())->count() }}">
                            {{ \App\Models\Appointment\Appointment::where('doctor_id', auth()->user()->doctor->id)->whereDate('start_at', today())->count() }}
                        </h2>
                        <small>Appointments today</small>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-clock stat-icon"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-6">
        <div class="dashboard-card card gradient-info text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="card-title">Pending</h6>
                        <h2 class="mb-0 stat-number" data-count="{{ \App\Models\Appointment\Appointment::where('doctor_id', auth()->user()->doctor->id)->where('status', 'pending')->count() }}">
                            {{ \App\Models\Appointment\Appointment::where('doctor_id', auth()->user()->doctor->id)->where('status', 'pending')->count() }}
                        </h2>
                        <small>Awaiting confirmation</small>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-hourglass-half stat-icon"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-6">
        <div class="dashboard-card card gradient-warning text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="card-title">My Prescriptions</h6>
                        <h2 class="mb-0 stat-number" data-count="{{ \App\Models\Prescription\Prescription::where('doctor_id', auth()->user()->doctor->id)->count() }}">
                            {{ \App\Models\Prescription\Prescription::where('doctor_id', auth()->user()->doctor->id)->count() }}
                        </h2>
                        <small>Created prescriptions</small>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-prescription stat-icon"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Today's Schedule and Quick Actions -->
<div class="row mt-4">
    <!-- Today's Appointments -->
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-calendar-day me-2"></i>
                    Today's Schedule
                </h5>
            </div>
            <div class="card-body">
                @php
                    $todayAppointments = \App\Models\Appointment\Appointment::with(['patient.profile'])
                        ->where('doctor_id', auth()->user()->doctor->id)
                        ->whereDate('start_at', today())
                        ->orderBy('start_at')
                        ->get();
                @endphp

                @forelse($todayAppointments as $appointment)
                    <div class="appointment-card">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="flex-grow-1">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0 me-3">
                                        <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                            {{ strtoupper(substr($appointment->patient->name ?? 'U', 0, 1)) }}
                                        </div>
                                    </div>
                                    <div>
                                        <h6 class="mb-1">{{ $appointment->patient->name ?? 'Unknown Patient' }}</h6>
                                        <p class="mb-1 text-muted">{{ \Carbon\Carbon::parse($appointment->start_at)->format('h:i A') }} - {{ \Carbon\Carbon::parse($appointment->end_at)->format('h:i A') }}</p>
                                        @if($appointment->reason)
                                            <small class="text-muted">{{ Str::limit($appointment->reason, 50) }}</small>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="text-end">
                                <span class="badge bg-{{ $appointment->status === 'confirmed' ? 'success' : 'warning' }} mb-2">
                                    {{ ucfirst($appointment->status) }}
                                </span>
                                <br>
                                @if($appointment->status === 'pending')
                                    <button class="btn btn-success btn-sm me-1" onclick="confirmAppointment({{ $appointment->id }})">
                                        <i class="fas fa-check me-1"></i>Confirm
                                    </button>
                                    <button class="btn btn-danger btn-sm" onclick="rejectAppointment({{ $appointment->id }})">
                                        <i class="fas fa-times me-1"></i>Reject
                                    </button>
                                @elseif($appointment->status === 'confirmed')
                                    @php
                                        $existingPrescription = \App\Models\Prescription\Prescription::where('appointment_id', $appointment->id)->first();
                                    @endphp
                                    @if(!$existingPrescription)
                                        <a href="{{ route('administration.prescriptions.create', $appointment->id) }}" class="btn btn-primary btn-sm">
                                            <i class="fas fa-prescription me-1"></i>Create Prescription
                                        </a>
                                    @else
                                        <a href="{{ route('administration.prescriptions.show', $appointment->id) }}" class="btn btn-info btn-sm me-1">
                                            <i class="fas fa-eye me-1"></i>View Prescription
                                        </a>
                                        <a href="{{ route('administration.prescriptions.pdf', $appointment->id) }}" class="btn btn-outline-info btn-sm" target="_blank">
                                            <i class="fas fa-download me-1"></i>PDF
                                        </a>
                                    @endif
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-4">
                        <i class="fas fa-calendar-times text-muted mb-3" style="font-size: 3rem;"></i>
                        <h5 class="text-muted">No appointments scheduled for today</h5>
                        <p class="text-muted">Your schedule is clear for today.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Quick Actions & Profile -->
    <div class="col-lg-4">
        <!-- Quick Actions -->
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-bolt me-2"></i>
                    Quick Actions
                </h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('administration.appointment.myPatientsAppointments') }}" class="btn btn-primary">
                        <i class="fas fa-calendar-alt me-2"></i>View All Appointments
                    </a>
                    <a href="{{ route('administration.prescriptions.index') }}" class="btn btn-success">
                        <i class="fas fa-prescription me-2"></i>My Prescriptions
                    </a>
                    <a href="{{ route('profile.edit') }}" class="btn btn-info">
                        <i class="fas fa-user-edit me-2"></i>Update Profile
                    </a>
                </div>
            </div>
        </div>

        <!-- Doctor Profile Summary -->
        <div class="card mt-3">
            <div class="card-header">
                <h6 class="card-title mb-0">
                    <i class="fas fa-user-md me-2"></i>
                    My Profile
                </h6>
            </div>
            <div class="card-body text-center">
                @php
                    $doctor = auth()->user()->doctor;
                @endphp
                @if($doctor)
                    <div class="mb-3">
                        <h5 class="mb-1">{{ $doctor->specialty ?? 'General Medicine' }}</h5>
                        <p class="text-muted mb-2">{{ $doctor->qualification ?? 'Medical Professional' }}</p>
                        @if($doctor->experience_years)
                            <span class="badge bg-info">{{ $doctor->experience_years }} years experience</span>
                        @endif
                    </div>
                    <div class="d-grid gap-2">
                        <a href="{{ route('profile.edit') }}" class="btn btn-outline-primary btn-sm">
                            <i class="fas fa-edit me-1"></i>Edit Profile
                        </a>
                    </div>
                @else
                    <div class="text-center py-3">
                        <i class="fas fa-user-md text-muted mb-2" style="font-size: 2rem;"></i>
                        <p class="text-muted mb-0">Complete your doctor profile</p>
                        <a href="{{ route('profile.edit') }}" class="btn btn-primary btn-sm mt-2">
                            Setup Profile
                        </a>
                    </div>
                @endif
            </div>
        </div>

        <!-- Upcoming Appointments Preview -->
        <div class="card mt-3">
            <div class="card-header">
                <h6 class="card-title mb-0">
                    <i class="fas fa-calendar-week me-2"></i>
                    This Week
                </h6>
            </div>
            <div class="card-body">
                @php
                    $weekAppointments = \App\Models\Appointment\Appointment::where('doctor_id', auth()->user()->doctor->id)
                        ->whereBetween('start_at', [now()->startOfWeek(), now()->endOfWeek()])
                        ->count();
                @endphp
                <div class="text-center">
                    <h3 class="text-primary mb-1">{{ $weekAppointments }}</h3>
                    <p class="text-muted mb-0">Total appointments</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Recent Prescriptions -->
<div class="row mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-prescription me-2"></i>
                    Recent Prescriptions
                </h5>
            </div>
            <div class="card-body">
                @php
                    $recentPrescriptions = \App\Models\Prescription\Prescription::with(['patient.profile', 'items'])
                        ->where('doctor_id', auth()->user()->doctor->id)
                        ->latest()->limit(5)->get();
                @endphp

                @forelse($recentPrescriptions as $prescription)
                    <div class="prescription-card">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="flex-grow-1">
                                <h6 class="mb-1">{{ $prescription->patient->name ?? 'Unknown Patient' }}</h6>
                                <p class="mb-1 opacity-75">{{ $prescription->created_at->format('M d, Y \a\t h:i A') }}</p>
                                <small class="opacity-75">{{ $prescription->items->count() }} medicines • {{ $prescription->diagnosis }}</small>
                            </div>
                            <div class="text-end">
                                <a href="{{ route('administration.prescriptions.show', $prescription->appointment_id) }}"
                                   class="btn btn-light btn-sm me-2">
                                    <i class="fas fa-eye me-1"></i>View
                                </a>
                                <a href="{{ route('administration.prescriptions.pdf', $prescription->appointment_id) }}"
                                   class="btn btn-light btn-sm" target="_blank">
                                    <i class="fas fa-download me-1"></i>PDF
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-4">
                        <i class="fas fa-prescription-bottle text-muted mb-3" style="font-size: 3rem;"></i>
                        <h5 class="text-muted">No prescriptions created yet</h5>
                        <p class="text-muted">Prescriptions will appear here after you confirm appointments and create them.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

<script>
function confirmAppointment(id) {
    if (confirm('Are you sure you want to confirm this appointment?')) {
        // Make AJAX call to confirm appointment
        $.post(`/appointments/${id}/confirm`)
            .done(function() {
                location.reload();
            })
            .fail(function() {
                alert('Failed to confirm appointment. Please try again.');
            });
    }
}

function rejectAppointment(id) {
    if (confirm('Are you sure you want to reject this appointment?')) {
        // Make AJAX call to reject appointment
        $.post(`/appointments/${id}/reject`)
            .done(function() {
                location.reload();
            })
            .fail(function() {
                alert('Failed to reject appointment. Please try again.');
            });
    }
}
</script>