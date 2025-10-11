@extends('layouts.administration.app')
@section('admin_title_content')
    {{config('app.name')}} || All Prescriptions
@endsection
@section('admin_content_header')
    <div class="col-sm-6">
        <h1 class="m-0">Prescriptions Management</h1>
    </div><!-- /.col -->
    <!-- breadcrumb -->
    <x-ad-breadcrumb :items="[
        ['label' => 'Dashboard', 'url' => route('dashboard')],
        ['label' => 'All Prescriptions', 'url' => route('administration.prescriptions.index')],
        ['label' => 'Manage'],
    ]" />
@endsection

@section('admin_vendor_css')
    @include('admin.additionalObject.datatable-css')
@endsection

@section('admin_page_css')
<style>
    .prescription-card {
        transition: transform 0.2s;
        border: none;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    .prescription-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.15);
    }
    .status-badge {
        font-size: 0.8em;
    }
    .medicine-item {
        background: #f8f9fa;
        padding: 8px 12px;
        margin-bottom: 4px;
        border-radius: 6px;
        border-left: 3px solid var(--bs-primary);
    }
</style>
@endsection

@section('main_content')
    <div class="container-fluid">
        <!-- Stats Overview -->
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card bg-primary text-white">
                    <div class="card-body">
                        <h6 class="card-title">Total Prescriptions</h6>
                        <h2 class="mb-0">{{ $prescriptions->total() }}</h2>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-success text-white">
                    <div class="card-body">
                        <h6 class="card-title">This Month</h6>
                        <h2 class="mb-0">{{ $prescriptions->where('created_at', '>=', now()->startOfMonth())->count() }}</h2>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-info text-white">
                    <div class="card-body">
                        <h6 class="card-title">Active Doctors</h6>
                        <h2 class="mb-0">{{ $prescriptions->pluck('doctor.user')->unique('id')->count() }}</h2>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-warning text-dark">
                    <div class="card-body">
                        <h6 class="card-title">This Week</h6>
                        <h2 class="mb-0">{{ $prescriptions->where('created_at', '>=', now()->startOfWeek())->count() }}</h2>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <h3 class="card-title mb-0">All Prescriptions</h3>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex gap-2 justify-content-end">
                                    <select id="statusFilter" class="form-select form-select-sm" style="width: auto;">
                                        <option value="">All Status</option>
                                        <option value="active">Active</option>
                                    </select>
                                    <select id="doctorFilter" class="form-select form-select-sm" style="width: auto;">
                                        <option value="">All Doctors</option>
                                        @foreach($prescriptions->pluck('doctor.user')->unique('id') as $doctor)
                                            <option value="{{ $doctor->id }}">{{ $doctor->name }}</option>
                                        @endforeach
                                    </select>
                                    <div class="input-group input-group-sm" style="width: 250px;">
                                        <input type="text" id="searchInput" class="form-control" placeholder="Search prescriptions...">
                                        <button type="button" class="btn btn-outline-secondary">
                                            <i class="fas fa-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        @forelse($prescriptions as $key => $prescription)
                            <div class="prescription-card card mb-3" data-doctor-id="{{ $prescription->doctor->user->id }}">
                                <div class="card-header bg-light">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h5 class="mb-1">Prescription #{{ $prescription->id }}</h5>
                                            <small class="text-muted">
                                                <i class="fas fa-calendar me-1"></i>
                                                {{ $prescription->created_at->format('M d, Y \a\t h:i A') }}
                                            </small>
                                        </div>
                                        <div class="text-end">
                                            <span class="badge bg-success status-badge">Active</span>
                                            <a href="{{ route('administration.prescriptions.pdf', $prescription->appointment_id) }}"
                                               class="btn btn-sm btn-outline-primary ms-2" target="_blank">
                                                <i class="fas fa-download me-1"></i> PDF
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <h6 class="text-muted mb-2">Patient Information</h6>
                                            <p class="mb-1"><strong>{{ $prescription->patient->name }}</strong></p>
                                            <small class="text-muted">
                                                <i class="fas fa-phone me-1"></i>
                                                {{ $prescription->patient->profile->contact_no ?? 'N/A' }}
                                            </small>
                                        </div>
                                        <div class="col-md-6">
                                            <h6 class="text-muted mb-2">Doctor Information</h6>
                                            <p class="mb-1"><strong>{{ $prescription->doctor->user->name }}</strong></p>
                                            <small class="text-muted">
                                                <i class="fas fa-stethoscope me-1"></i>
                                                {{ $prescription->doctor->specialty ?? 'General' }}
                                            </small>
                                        </div>
                                    </div>

                                    @if($prescription->diagnosis)
                                        <div class="mt-3">
                                            <h6 class="text-muted mb-2">Diagnosis</h6>
                                            <p class="mb-2">{{ $prescription->diagnosis }}</p>
                                        </div>
                                    @endif

                                    @if($prescription->items && $prescription->items->count() > 0)
                                        <div class="mt-3">
                                            <h6 class="text-muted mb-2">Medicines Prescribed</h6>
                                            @foreach($prescription->items as $item)
                                                <div class="medicine-item">
                                                    <strong>{{ $item->medicine_name }}</strong><br>
                                                    <small class="text-muted">
                                                        Dosage: {{ $item->dosage }} |
                                                        Duration: {{ $item->duration }} |
                                                        Frequency: {{ $item->frequency }}
                                                    </small>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif

                                    @if($prescription->instructions)
                                        <div class="mt-3">
                                            <h6 class="text-muted mb-2">Instructions</h6>
                                            <p class="mb-0">{{ $prescription->instructions }}</p>
                                        </div>
                                    @endif

                                    @if($prescription->notes)
                                        <div class="mt-3">
                                            <h6 class="text-muted mb-2">Additional Notes</h6>
                                            <p class="mb-0">{{ $prescription->notes }}</p>
                                        </div>
                                    @endif

                                    <div class="mt-3 pt-3 border-top">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <small class="text-muted">
                                                Appointment: #{{ $prescription->appointment_id }}
                                            </small>
                                            <div>
                                                <a href="{{ route('administration.prescriptions.show', $prescription->appointment_id) }}"
                                                   class="btn btn-sm btn-primary">
                                                    <i class="fas fa-eye me-1"></i> View Details
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-5">
                                <i class="fas fa-prescription text-muted mb-3" style="font-size: 3rem;"></i>
                                <h4 class="text-muted">No Prescriptions Found</h4>
                                <p class="text-muted">Prescriptions will appear here once doctors create them for confirmed appointments.</p>
                            </div>
                        @endforelse
                    </div>
                    <!-- /.card-body -->

                    @if($prescriptions->hasPages())
                        <div class="card-footer">
                            <div class="d-flex justify-content-center">
                                {{ $prescriptions->links() }}
                            </div>
                        </div>
                    @endif
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
@endsection
@section('admin_vendor_js')
@endsection
@section('admin_page_js')
@include('admin.additionalObject.datatable-js')
<script>
$(document).ready(function() {
    // Filter functionality
    function applyFilters() {
        const searchTerm = $('#searchInput').val().toLowerCase();
        const statusFilter = $('#statusFilter').val().toLowerCase();
        const doctorFilter = $('#doctorFilter').val();

        $('.prescription-card').each(function() {
            const card = $(this);
            const text = card.text().toLowerCase();
            const cardDoctorId = card.data('doctor-id');

            let showCard = true;

            // Search filter
            if (searchTerm && !text.includes(searchTerm)) {
                showCard = false;
            }

            // Status filter
            if (statusFilter && !card.hasClass('status-' + statusFilter)) {
                showCard = false;
            }

            // Doctor filter
            if (doctorFilter && cardDoctorId != doctorFilter) {
                showCard = false;
            }

            if (showCard) {
                card.show();
            } else {
                card.hide();
            }
        });

        // Update visible count
        updateVisibleCount();
    }

    function updateVisibleCount() {
        const visibleCards = $('.prescription-card:visible').length;
        const totalCards = $('.prescription-card').length;

        if (visibleCards === 0 && totalCards > 0) {
            $('.prescription-card').first().closest('.card-body').append(`
                <div class="no-results text-center py-4" style="display: block;">
                    <i class="fas fa-search text-muted mb-3" style="font-size: 2rem;"></i>
                    <p class="text-muted mb-0">No prescriptions match your search criteria.</p>
                </div>
            `);
        } else {
            $('.no-results').remove();
        }
    }

    // Event listeners
    $('#searchInput').on('keyup', applyFilters);
    $('#statusFilter').on('change', applyFilters);
    $('#doctorFilter').on('change', applyFilters);

    // Initialize doctor IDs on cards
    $('.prescription-card').each(function() {
        const doctorName = $(this).find('.card-body').text();
        const doctorMatch = doctorName.match(/Dr\.\s+([^\n\r]+)/);
        if (doctorMatch) {
            const doctorText = doctorMatch[1].trim();
            // You might want to add data attribute based on actual doctor ID
            // For now, we'll use a simple text-based filter
        }
    });
});
</script>
@endsection