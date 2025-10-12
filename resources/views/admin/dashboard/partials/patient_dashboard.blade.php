<!-- Patient Dashboard Content -->
<div class="row">
    <!-- Patient Statistics -->
    <div class="col-lg-3 col-6">
        <div class="dashboard-card card gradient-primary text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="card-title">My Appointments</h6>
                        <h2 class="mb-0 stat-number" data-count="{{ \App\Models\Appointment\Appointment::where('patient_id', auth()->id())->count() }}">
                            {{ \App\Models\Appointment\Appointment::where('patient_id', auth()->id())->count() }}
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
        <div class="dashboard-card card gradient-success text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="card-title">Upcoming</h6>
                        <h2 class="mb-0 stat-number" data-count="{{ \App\Models\Appointment\Appointment::where('patient_id', auth()->id())->where('start_at', '>', now())->where('status', '!=', 'cancelled')->count() }}">
                            {{ \App\Models\Appointment\Appointment::where('patient_id', auth()->id())->where('start_at', '>', now())->where('status', '!=', 'cancelled')->count() }}
                        </h2>
                        <small>Upcoming appointments</small>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-calendar-alt stat-icon"></i>
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
                        <h6 class="card-title">Prescriptions</h6>
                        <h2 class="mb-0 stat-number" data-count="{{ \App\Models\Prescription\Prescription::where('patient_id', auth()->id())->count() }}">
                            {{ \App\Models\Prescription\Prescription::where('patient_id', auth()->id())->count() }}
                        </h2>
                        <small>Available prescriptions</small>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-prescription stat-icon"></i>
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
                        <h6 class="card-title">This Month</h6>
                        <h2 class="mb-0 stat-number" data-count="{{ \App\Models\Appointment\Appointment::where('patient_id', auth()->id())->whereMonth('start_at', now()->month)->count() }}">
                            {{ \App\Models\Appointment\Appointment::where('patient_id', auth()->id())->whereMonth('start_at', now()->month)->count() }}
                        </h2>
                        <small>Appointments this month</small>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-calendar-day stat-icon"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Next Appointment and Quick Actions -->
<div class="row mt-4">
    <!-- Next Appointment -->
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-calendar-clock me-2"></i>
                    Next Appointment
                </h5>
            </div>
            <div class="card-body">
                @php
                    $nextAppointment = \App\Models\Appointment\Appointment::with(['doctor.user'])
                        ->where('patient_id', auth()->id())
                        ->where('start_at', '>', now())
                        ->where('status', '!=', 'cancelled')
                        ->orderBy('start_at')
                        ->first();
                @endphp

                @if($nextAppointment)
                    <div class="appointment-card">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="flex-grow-1">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0 me-3">
                                        <div class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                            <i class="fas fa-user-md"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <h5 class="mb-1">Dr. {{ $nextAppointment->doctor->user->name ?? 'Unknown Doctor' }}</h5>
                                        <p class="mb-2">{{ $nextAppointment->doctor->specialty ?? 'General Medicine' }}</p>
                                        <div class="d-flex align-items-center text-muted">
                                            <i class="fas fa-calendar me-2"></i>
                                            {{ \Carbon\Carbon::parse($nextAppointment->start_at)->format('l, F j, Y') }}
                                        </div>
                                        <div class="d-flex align-items-center text-muted mt-1">
                                            <i class="fas fa-clock me-2"></i>
                                            {{ \Carbon\Carbon::parse($nextAppointment->start_at)->format('h:i A') }} -
                                            {{ \Carbon\Carbon::parse($nextAppointment->end_at)->format('h:i A') }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="text-end">
                                <span class="badge bg-success mb-2">Confirmed</span>
                                <br>
                                <a href="{{ route('administration.appointment.show', $nextAppointment->id) }}" class="btn btn-primary btn-sm">
                                    <i class="fas fa-eye me-1"></i>View Details
                                </a>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="fas fa-calendar-plus text-muted mb-3" style="font-size: 4rem;"></i>
                        <h4 class="text-muted">No upcoming appointments</h4>
                        <p class="text-muted mb-3">Schedule your next appointment with a doctor.</p>
                        <a href="{{ route('administration.appointment.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus me-2"></i>Book Appointment
                        </a>
                    </div>
                @endif
            </div>
        </div>

        <!-- Recent Prescriptions -->
        <div class="card mt-3">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-prescription me-2"></i>
                    Recent Prescriptions
                </h5>
            </div>
            <div class="card-body">
                @php
                    $recentPrescriptions = \App\Models\Prescription\Prescription::with(['doctor.user', 'items'])
                        ->where('patient_id', auth()->id())
                        ->latest()->limit(3)->get();
                @endphp

                @forelse($recentPrescriptions as $prescription)
                    <div class="prescription-card">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="flex-grow-1">
                                <h6 class="mb-1">Dr. {{ $prescription->doctor->user->name ?? 'Unknown Doctor' }}</h6>
                                <p class="mb-1 opacity-75">{{ $prescription->created_at->format('M d, Y') }}</p>
                                <small class="opacity-75">{{ $prescription->items->count() }} medicines prescribed</small>
                            </div>
                            <div>
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
                        <h5 class="text-muted">No prescriptions yet</h5>
                        <p class="text-muted">Prescriptions will appear here after your appointments.</p>
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
                    <a href="{{ route('administration.appointment.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>Book New Appointment
                    </a>
                    <a href="{{ route('administration.appointment.myAppointments') }}" class="btn btn-info">
                        <i class="fas fa-list me-2"></i>My Appointments
                    </a>
                    <a href="{{ route('administration.prescriptions.index') }}" class="btn btn-success">
                        <i class="fas fa-prescription me-2"></i>My Prescriptions
                    </a>
                    <a href="{{ route('profile.edit') }}" class="btn btn-warning">
                        <i class="fas fa-user-edit me-2"></i>Update Profile
                    </a>
                </div>
            </div>
        </div>

        <!-- Health Profile -->
        <div class="card mt-3">
            <div class="card-header">
                <h6 class="card-title mb-0">
                    <i class="fas fa-heartbeat me-2"></i>
                    Health Profile
                </h6>
            </div>
            <div class="card-body">
                @php
                    $profile = auth()->user()->profile;
                @endphp
                @if($profile)
                    <div class="mb-3">
                        @if($profile->blood_group)
                            <div class="d-flex justify-content-between mb-2">
                                <span>Blood Group:</span>
                                <span class="badge bg-danger">{{ $profile->blood_group }}</span>
                            </div>
                        @endif
                        @if($profile->date_of_birth)
                            <div class="d-flex justify-content-between mb-2">
                                <span>Age:</span>
                                <span>{{ \Carbon\Carbon::parse($profile->date_of_birth)->age }} years</span>
                            </div>
                        @endif
                        @if($profile->gender)
                            <div class="d-flex justify-content-between mb-2">
                                <span>Gender:</span>
                                <span>{{ ucfirst($profile->gender) }}</span>
                            </div>
                        @endif
                    </div>
                    <a href="{{ route('profile.edit') }}" class="btn btn-outline-primary btn-sm w-100">
                        <i class="fas fa-edit me-1"></i>Update Health Profile
                    </a>
                @else
                    <div class="text-center py-3">
                        <i class="fas fa-user-md text-muted mb-2" style="font-size: 2rem;"></i>
                        <p class="text-muted mb-2">Complete your health profile</p>
                        <a href="{{ route('profile.edit') }}" class="btn btn-primary btn-sm">
                            Setup Profile
                        </a>
                    </div>
                @endif
            </div>
        </div>

        <!-- Appointment History -->
        <div class="card mt-3">
            <div class="card-header">
                <h6 class="card-title mb-0">
                    <i class="fas fa-history me-2"></i>
                    Appointment History
                </h6>
            </div>
            <div class="card-body">
                @php
                    $totalAppointments = \App\Models\Appointment\Appointment::where('patient_id', auth()->id())->count();
                    $completedAppointments = \App\Models\Appointment\Appointment::where('patient_id', auth()->id())->where('status', 'completed')->count();
                    $cancelledAppointments = \App\Models\Appointment\Appointment::where('patient_id', auth()->id())->where('status', 'cancelled')->count();
                @endphp

                <div class="row text-center">
                    <div class="col-4">
                        <h5 class="text-primary mb-1">{{ $totalAppointments }}</h5>
                        <small class="text-muted">Total</small>
                    </div>
                    <div class="col-4">
                        <h5 class="text-success mb-1">{{ $completedAppointments }}</h5>
                        <small class="text-muted">Completed</small>
                    </div>
                    <div class="col-4">
                        <h5 class="text-danger mb-1">{{ $cancelledAppointments }}</h5>
                        <small class="text-muted">Cancelled</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Health Tips -->
<div class="row mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-info text-white">
                <h5 class="card-title mb-0">
                    <i class="fas fa-lightbulb me-2"></i>
                    Health Tips
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <div class="text-center">
                            <i class="fas fa-water fa-2x text-primary mb-2"></i>
                            <h6>Stay Hydrated</h6>
                            <p class="text-muted small">Drink at least 8 glasses of water daily</p>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="text-center">
                            <i class="fas fa-running fa-2x text-success mb-2"></i>
                            <h6>Exercise Regularly</h6>
                            <p class="text-muted small">30 minutes of daily exercise keeps you healthy</p>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="text-center">
                            <i class="fas fa-clock fa-2x text-warning mb-2"></i>
                            <h6>Regular Checkups</h6>
                            <p class="text-muted small">Schedule regular health checkups</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>