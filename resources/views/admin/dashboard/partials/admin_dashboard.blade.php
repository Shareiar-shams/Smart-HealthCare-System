<!-- Admin Dashboard Content -->
<div class="row">
    <!-- Statistics Cards -->
    <div class="col-lg-3 col-6">
        <div class="dashboard-card card gradient-primary text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="card-title">Total Users</h6>
                        <h2 class="mb-0 stat-number" data-count="{{ \App\Models\User::count() }}">{{ \App\Models\User::count() }}</h2>
                        <small>Registered users</small>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-users stat-icon"></i>
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
                        <h6 class="card-title">Total Doctors</h6>
                        <h2 class="mb-0 stat-number" data-count="{{ \App\Models\Doctor\Doctor::count() }}">{{ \App\Models\Doctor\Doctor::count() }}</h2>
                        <small>Active doctors</small>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-user-md stat-icon"></i>
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
                        <h6 class="card-title">Appointments</h6>
                        <h2 class="mb-0 stat-number" data-count="{{ \App\Models\Appointment\Appointment::count() }}">{{ \App\Models\Appointment\Appointment::count() }}</h2>
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
        <div class="dashboard-card card gradient-warning text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="card-title">Prescriptions</h6>
                        <h2 class="mb-0 stat-number" data-count="{{ \App\Models\Prescription\Prescription::count() }}">{{ \App\Models\Prescription\Prescription::count() }}</h2>
                        <small>Total prescriptions</small>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-prescription stat-icon"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Charts and Details Row -->
<div class="row mt-4">
    <!-- Appointment Status Chart -->
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-chart-bar me-2"></i>
                    Appointment Overview
                </h5>
            </div>
            <div class="card-body">
                <canvas id="appointmentChart" style="max-height: 300px;"></canvas>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="col-lg-4">
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
                        <i class="fas fa-plus me-2"></i>Create Appointment
                    </a>
                    <a href="{{ route('administration.appointment.index') }}" class="btn btn-info">
                        <i class="fas fa-list me-2"></i>Manage Appointments
                    </a>
                    <a href="{{ route('administration.prescriptions.index') }}" class="btn btn-success">
                        <i class="fas fa-prescription me-2"></i>View Prescriptions
                    </a>
                    <a href="{{ route('administration.settings.user.index') }}" class="btn btn-warning">
                        <i class="fas fa-users me-2"></i>Manage Users
                    </a>
                </div>
            </div>
        </div>

        <!-- System Status -->
        <div class="card mt-3">
            <div class="card-header">
                <h6 class="card-title mb-0">
                    <i class="fas fa-server me-2"></i>
                    System Status
                </h6>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span>Database</span>
                    <span class="badge bg-success">Connected</span>
                </div>
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span>Cache</span>
                    <span class="badge bg-success">Active</span>
                </div>
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span>Storage</span>
                    <span class="badge bg-success">Available</span>
                </div>
                <div class="d-flex justify-content-between align-items-center">
                    <span>Queue</span>
                    <span class="badge bg-info">Processing</span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Recent Appointments and Prescriptions -->
<div class="row mt-4">
    <!-- Recent Appointments -->
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-calendar-alt me-2"></i>
                    Recent Appointments
                </h5>
            </div>
            <div class="card-body">
                @php
                    $recentAppointments = \App\Models\Appointment\Appointment::with(['doctor.user', 'patient'])
                        ->latest()->limit(5)->get();
                @endphp

                @forelse($recentAppointments as $appointment)
                    <div class="appointment-card">
                        <div class="d-flex justify-content-between align-items-start">
                            <div class="flex-grow-1">
                                <h6 class="mb-1">{{ $appointment->patient->name ?? 'Unknown Patient' }}</h6>
                                <p class="mb-1 text-muted">Dr. {{ $appointment->doctor->user->name ?? 'Unknown Doctor' }}</p>
                                <small class="text-muted">
                                    {{ $appointment->appointment_date ?
                                       \Carbon\Carbon::parse($appointment->appointment_date)->format('M d, Y') :
                                       \Carbon\Carbon::parse($appointment->start_at)->format('M d, Y') }}
                                    at {{ \Carbon\Carbon::parse($appointment->start_at)->format('h:i A') }}
                                </small>
                            </div>
                            <span class="badge bg-{{ $appointment->status === 'confirmed' ? 'success' : ($appointment->status === 'pending' ? 'warning' : 'danger') }}">
                                {{ ucfirst($appointment->status) }}
                            </span>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-3">
                        <i class="fas fa-calendar-times text-muted mb-2" style="font-size: 2rem;"></i>
                        <p class="text-muted mb-0">No recent appointments</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Recent Prescriptions -->
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-prescription me-2"></i>
                    Recent Prescriptions
                </h5>
            </div>
            <div class="card-body">
                @php
                    $recentPrescriptions = \App\Models\Prescription\Prescription::with(['patient', 'doctor.user'])
                        ->latest()->limit(5)->get();
                @endphp

                @forelse($recentPrescriptions as $prescription)
                    <div class="prescription-card">
                        <div class="d-flex justify-content-between align-items-start">
                            <div class="flex-grow-1">
                                <h6 class="mb-1">{{ $prescription->patient->name ?? 'Unknown Patient' }}</h6>
                                <p class="mb-1 opacity-75">Dr. {{ $prescription->doctor->user->name ?? 'Unknown Doctor' }}</p>
                                <small class="opacity-75">
                                    {{ $prescription->created_at->format('M d, Y') }}
                                    • {{ $prescription->items->count() }} medicines
                                </small>
                            </div>
                            <a href="{{ route('administration.prescriptions.show', $prescription->appointment_id) }}"
                               class="btn btn-light btn-sm">
                                <i class="fas fa-eye"></i>
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-3">
                        <i class="fas fa-prescription-bottle text-muted mb-2" style="font-size: 2rem;"></i>
                        <p class="text-muted mb-0">No recent prescriptions</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Appointment Status Chart
    const ctx = document.getElementById('appointmentChart').getContext('2d');
    const appointmentData = {
        labels: ['Pending', 'Confirmed', 'Completed', 'Cancelled'],
        datasets: [{
            label: 'Appointments',
            data: [
                {{ \App\Models\Appointment\Appointment::where('status', 'pending')->count() }},
                {{ \App\Models\Appointment\Appointment::where('status', 'confirmed')->count() }},
                {{ \App\Models\Appointment\Appointment::where('status', 'completed')->count() }},
                {{ \App\Models\Appointment\Appointment::where('status', 'cancelled')->count() }}
            ],
            backgroundColor: [
                'rgba(255, 193, 7, 0.8)',
                'rgba(40, 167, 69, 0.8)',
                'rgba(23, 162, 184, 0.8)',
                'rgba(220, 53, 69, 0.8)'
            ],
            borderColor: [
                'rgba(255, 193, 7, 1)',
                'rgba(40, 167, 69, 1)',
                'rgba(23, 162, 184, 1)',
                'rgba(220, 53, 69, 1)'
            ],
            borderWidth: 1
        }]
    };

    new Chart(ctx, {
        type: 'doughnut',
        data: appointmentData,
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                }
            }
        }
    });
});
</script>