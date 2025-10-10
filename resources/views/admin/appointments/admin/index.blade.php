@extends('layouts.administration.app')

@section('admin_title_content')
    Smart HealthCare | Appointment Management
@endsection

@section('admin_content_header')
    <div class="col-sm-6">
        <h1 class="m-0">{{__('Appointment Management')}}</h1>
    </div>
    <x-ad-breadcrumb :items="[
        ['label' => 'Dashboard', 'url' => route('dashboard')],
        ['label' => 'Appointments'],
        ['label' => 'Management'],
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
    .chart-container {
        position: relative;
        height: 300px;
    }
</style>
@endsection

@section('main_content')
<div class="container-fluid">
    <!-- Stats Overview -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card stats-card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="card-title text-muted">Total Appointments</h6>
                            <h2 class="mb-0">{{ $stats['total'] }}</h2>
                        </div>
                        <div class="text-primary">
                            <i class="fas fa-calendar fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card stats-card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="card-title text-muted">Today's Appointments</h6>
                            <h2 class="mb-0">{{ $stats['today'] }}</h2>
                        </div>
                        <div class="text-success">
                            <i class="fas fa-calendar-day fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card stats-card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="card-title text-muted">Active Doctors</h6>
                            <h2 class="mb-0">{{ $stats['doctors'] }}</h2>
                        </div>
                        <div class="text-info">
                            <i class="fas fa-user-md fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card stats-card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="card-title text-muted">Total Patients</h6>
                            <h2 class="mb-0">{{ $stats['patients'] }}</h2>
                        </div>
                        <div class="text-warning">
                            <i class="fas fa-users fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Appointment Filters and List -->
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Appointments</h5>
                </div>
                <div class="card-body">
                    <!-- Filters -->
                    <div class="row g-3 mb-4">
                        <div class="col-md-3">
                            <select class="form-select" id="statusFilter">
                                <option value="">All Status</option>
                                <option value="pending">Pending</option>
                                <option value="confirmed">Confirmed</option>
                                <option value="canceled">Canceled</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select class="form-select" id="doctorFilter">
                                <option value="">All Doctors</option>
                                @foreach($doctors as $doctor)
                                    <option value="{{ $doctor->id }}">Dr. {{ $doctor->user->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <input type="date" class="form-control" id="dateFilter" 
                                value="{{ date('Y-m-d') }}">
                        </div>
                        <div class="col-md-3">
                            <div class="input-group">
                                <input type="text" class="form-control" id="searchInput" 
                                    placeholder="Search...">
                                <button class="btn btn-primary" type="button" id="searchBtn">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Appointments List -->
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

                    <!-- Pagination -->
                    <div class="d-flex justify-content-center mt-4">
                        {{ $appointments->links() }}
                    </div>
                </div>
            </div>
        </div>

        <!-- Analytics and Charts -->
        <div class="col-lg-4">
            <!-- Appointments by Status -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">Status Distribution</h5>
                </div>
                <div class="card-body">
                    <div class="chart-container">
                        <canvas id="statusChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- Weekly Trend -->
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Weekly Trend</h5>
                </div>
                <div class="card-body">
                    <div class="chart-container">
                        <canvas id="trendChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Edit Appointment Modal -->
<div class="modal fade" id="editAppointmentModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Appointment</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="editAppointmentForm" method="POST">
                @csrf
                @method('PATCH')
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select class="form-select" name="status" required>
                            <option value="pending">Pending</option>
                            <option value="confirmed">Confirmed</option>
                            <option value="canceled">Canceled</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Date</label>
                        <input type="date" class="form-control" name="date" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Time</label>
                        <input type="time" class="form-control" name="time" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Notes</label>
                        <textarea class="form-control" name="notes" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('admin_page_js')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
$(document).ready(function() {
    // Initialize Charts
    initializeCharts();

    // Filter handling
    $('.form-select, #dateFilter').change(function() {
        filterAppointments();
    });

    $('#searchInput').on('input', debounce(function() {
        filterAppointments();
    }, 300));

    function filterAppointments() {
        const filters = {
            status: $('#statusFilter').val(),
            doctor_id: $('#doctorFilter').val(),
            date: $('#dateFilter').val(),
            search: $('#searchInput').val()
        };

        $.get('{{ route("admin.appointments.filter") }}', filters, function(data) {
            $('.appointments-list').html(data);
        });
    }
});

function editAppointment(id) {
    // Fetch appointment details
    $.get(`/appointments/${id}`, function(data) {
        $('#editAppointmentForm').attr('action', `/appointments/${id}`);
        $('#editAppointmentForm select[name="status"]').val(data.status);
        $('#editAppointmentForm input[name="date"]').val(data.date);
        $('#editAppointmentForm input[name="time"]').val(data.time);
        $('#editAppointmentForm textarea[name="notes"]').val(data.notes);
        $('#editAppointmentModal').modal('show');
    });
}

function deleteAppointment(id) {
    if (confirm('Are you sure you want to delete this appointment?')) {
        $.post(`/appointments/${id}`, {
            _method: 'DELETE',
            _token: '{{ csrf_token() }}'
        }, function() {
            location.reload();
        });
    }
}

function initializeCharts() {
    // Status Distribution Chart
    new Chart(document.getElementById('statusChart'), {
        type: 'doughnut',
        data: {
            labels: ['Pending', 'Confirmed', 'Canceled'],
            datasets: [{
                data: {{ json_encode($charts['status']) }},
                backgroundColor: ['#ffc107', '#28a745', '#dc3545']
            }]
        }
    });

    // Weekly Trend Chart
    new Chart(document.getElementById('trendChart'), {
        type: 'line',
        data: {
            labels: {{ json_encode($charts['weekly']['labels']) }},
            datasets: [{
                label: 'Appointments',
                data: {{ json_encode($charts['weekly']['data']) }},
                borderColor: '#4e73df',
                tension: 0.1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            }
        }
    });
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