@extends('layouts.administration.app')

@section('title_content')
    {{config('app.name')}} || Appointment Management
@endsection

@section('content_header')
    <div class="col-sm-6">
        <h1 class="m-0">{{__('Appointment Management')}}</h1>
    </div>
    <x-ad-breadcrumb :items="[
        ['label' => 'Dashboard', 'url' => route('dashboard')],
        ['label' => 'Appointments', 'url' => route('administration.appointment.index')],
        ['label' => 'All Appointments'],
    ]" />
@endsection
@section('admin_vendor_css')
    <!-- Select2 -->
    <link rel="stylesheet" href="{{asset('assets/plugins/select2/css/select2.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">
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
                            <select class="form-select select2bs4" id="statusFilter">
                                <option value="">All Status</option>
                                <option value="pending">Pending</option>
                                <option value="confirmed">Confirmed</option>
                                <option value="canceled">Canceled</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select class="form-select select2bs4" id="doctorFilter">
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
                        @include('admin.appointments.admin._list', ['appointments' => $appointments])
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
  
@endsection

@section('admin_vendor_js')
<script src="{{ asset('assets/plugins/chart.js/Chart.bundle.min.js') }}"></script>
@endsection
@section('admin_page_js')
@include('admin.additionalObject.createDocumentScript')
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

            $.get('{{ route("administration.appointment.index") }}', filters, function(data) {
                $('.appointments-list').html(data);
            });
        }
    });

    function editAppointment(id) {
        window.location.href = '{{ route('administration.appointment.edit', ':id') }}'.replace(':id', id);
    }

    function deleteAppointment(id) {
        if (confirm('Are you sure you want to delete this appointment?')) {
            $.ajax({
                url: '{{ route('administration.appointment.delete', ':id') }}'.replace(':id', id),
                type: 'POST',
                data: {
                    _method: 'DELETE',
                    _token: '{{ csrf_token() }}'
                },
                success: function() {
                    // Refresh list using current filters
                    const filters = {
                        status: $('#statusFilter').val(),
                        doctor_id: $('#doctorFilter').val(),
                        date: $('#dateFilter').val(),
                        search: $('#searchInput').val()
                    };
                    $.get('{{ route('administration.appointment.index') }}', filters, function(data) {
                        $('.appointments-list').html(data);
                    });
                }
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
                labels: {!! json_encode($charts['weekly']['labels']) !!},
                datasets: [{
                    label: 'Appointments',
                    data: {!! json_encode($charts['weekly']['data']) !!},
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