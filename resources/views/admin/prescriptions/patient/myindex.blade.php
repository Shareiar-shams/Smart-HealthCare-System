@extends('layouts.administration.app')
@section('title_content')
    {{config('app.name')}} || All Prescriptions
@endsection
@section('content_header')
    <div class="col-sm-6">
        <h1 class="m-0">Prescriptions Management</h1>
    </div><!-- /.col -->
    <!-- breadcrumb -->
    <x-ad-breadcrumb :items="[
        ['label' => 'Dashboard', 'url' => route('dashboard')],
        ['label' => 'Manage Prescription'],
    ]" />
@endsection

@section('admin_vendor_css')
    <!-- Select2 -->
    <link rel="stylesheet" href="{{asset('assets/plugins/select2/css/select2.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">
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
        
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <h3 class="card-title mb-0">All Prescriptions</h3>
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
@include('admin.additionalObject.createDocumentScript')
@include('admin.additionalObject.datatable-js')

@endsection