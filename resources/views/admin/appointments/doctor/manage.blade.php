@extends('layouts.administration.app')

@section('admin_title_content')
    Smart HealthCare | Manage Appointments
@endsection

@section('admin_content_header')
    <div class="col-sm-6">
        <h1 class="m-0">{{__('Manage Appointments')}}</h1>
    </div>
    <x-ad-breadcrumb :items="[
        ['label' => 'Dashboard', 'url' => route('dashboard')],
        ['label' => 'Appointments'],
        ['label' => 'Manage'],
    ]" />
@endsection

@section('admin_page_css')
<style>
    .stats-card {
        border-radius: 8px;
        transition: transform 0.2s;
    }
    .stats-card:hover {
        transform: translateY(-5px);
    }
    .timeline-item {
        position: relative;
        padding-left: 2rem;
        margin-bottom: 1rem;
    }
    .timeline-item::before {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        bottom: 0;
        width: 2px;
        background: #e9ecef;
    }
    .timeline-item::after {
        content: '';
        position: absolute;
        left: -4px;
        top: 0;
        width: 10px;
        height: 10px;
        border-radius: 50%;
        background: var(--bs-primary);
    }
</style>
@endsection

@section('main_content')
<div class="container-fluid">
    <!-- Stats Overview -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card stats-card bg-primary text-white">
                <div class="card-body">
                    <h6 class="card-title">Today's Appointments</h6>
                    <h2 class="mb-0">{{ $stats['today'] }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card stats-card bg-success text-white">
                <div class="card-body">
                    <h6 class="card-title">Confirmed</h6>
                    <h2 class="mb-0">{{ $stats['confirmed'] }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card stats-card bg-warning text-dark">
                <div class="card-body">
                    <h6 class="card-title">Pending</h6>
                    <h2 class="mb-0">{{ $stats['pending'] }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card stats-card bg-info text-white">
                <div class="card-body">
                    <h6 class="card-title">This Week</h6>
                    <h2 class="mb-0">{{ $stats['week'] }}</h2>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Appointments List -->
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Upcoming Appointments</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-search"></i></span>
                            <input type="text" class="form-control" id="searchInput" 
                                placeholder="Search patient name...">
                            <input type="date" class="form-control" id="dateFilter" 
                                value="{{ date('Y-m-d') }}">
                            <button class="btn btn-primary" type="button" id="filterBtn">
                                Filter
                            </button>
                        </div>
                    </div>

                    <div class="appointments-list">
                        @forelse($appointments as $appointment)
                            <x-appointment-card :appointment="$appointment" />
                        @empty
                            <div class="text-center py-4">
                                <i class="fas fa-calendar-times text-muted mb-3" style="font-size: 2rem;"></i>
                                <p class="text-muted mb-0">No appointments found</p>
                            </div>
                        @endforelse
                    </div>

                    <div class="d-flex justify-content-center mt-3">
                        {{ $appointments->links() }}
                    </div>
                </div>
            </div>
        </div>

        <!-- Schedule Overview -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Today's Schedule</h5>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush">
                        @forelse($todayAppointments as $appointment)
                            <div class="list-group-item">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="mb-1">{{ \Carbon\Carbon::parse($appointment->start_at)->format('h:i A') }}</h6>
                                        <p class="mb-0 text-muted">{{ $appointment->patient->name }}</p>
                                    </div>
                                    <span class="badge bg-{{ $appointment->status === 'pending' ? 'warning' : ($appointment->status === 'confirmed' ? 'success' : 'danger') }}">
                                        {{ ucfirst($appointment->status) }}
                                    </span>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-4">
                                <p class="text-muted mb-0">No appointments scheduled for today</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Recent Activity -->
            <div class="card mt-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">Recent Activity</h5>
                </div>
                <div class="card-body">
                    <div class="timeline">
                        @foreach($recentActivity as $activity)
                            <div class="timeline-item">
                                <small class="text-muted">{{ $activity->created_at->diffForHumans() }}</small>
                                <p class="mb-0">{{ $activity->description }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Appointment Action Modals -->
<div class="modal fade" id="confirmAppointmentModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirm Appointment</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="confirmAppointmentForm" method="POST">
                @csrf
                @method('PATCH')
                <div class="modal-body">
                    <p>Are you sure you want to confirm this appointment?</p>
                    <div class="mb-3">
                        <label class="form-label">Add Notes (Optional)</label>
                        <textarea class="form-control" name="notes" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success">Confirm Appointment</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="rejectAppointmentModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Reject Appointment</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="rejectAppointmentForm" method="POST">
                @csrf
                @method('DELETE')
                <div class="modal-body">
                    <p>Are you sure you want to reject this appointment?</p>
                    <div class="mb-3">
                        <label class="form-label">Reason for Rejection</label>
                        <textarea class="form-control" name="cancel_reason" rows="3" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-danger">Reject Appointment</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('admin_page_js')
<script>
$(document).ready(function() {
    // Initialize filters
    $('#filterBtn').click(function() {
        filterAppointments();
    });

    // Search with debounce
    $('#searchInput').on('input', debounce(function() {
        filterAppointments();
    }, 300));

    function filterAppointments() {
        const search = $('#searchInput').val();
        const date = $('#dateFilter').val();

        $.get('{{ route("doctor.appointments") }}', {
            search: search,
            date: date
        }, function(data) {
            $('.appointments-list').html(data);
        });
    }
});

function confirmAppointment(id) {
    $('#confirmAppointmentForm').attr('action', `/appointments/${id}/confirm`);
    $('#confirmAppointmentModal').modal('show');
}

function rejectAppointment(id) {
    $('#rejectAppointmentForm').attr('action', `/appointments/${id}`);
    $('#rejectAppointmentModal').modal('show');
}

function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}
</script>
@endsection