@extends('layouts.administration.app')
@section('title_content')
   {{config('app.name')}} || My Appointments
@endsection
@section('content_header')
    <div class="col-sm-6">
        <h1 class="m-0">{{__('My Appointments')}}</h1>
    </div><!-- /.col -->
    <!-- breadcrumb -->
    <x-ad-breadcrumb :items="[
        ['label' => 'Dashboard', 'url' => route('dashboard')],
        ['label' => 'Appointments', 'url' => route('administration.appointment.index')],
        ['label' => 'My Appointments'],
    ]" />
@endsection
@section('admin_vendor_css')
    @include('admin.additionalObject.datatable-css')
@endsection

@section('admin_page_css')
<style>
    .prescription-badge {
        font-size: 0.75rem;
        padding: 0.25rem 0.5rem;
    }
    .prescription-actions .btn {
        padding: 0.25rem 0.5rem;
        font-size: 0.75rem;
    }
</style>
@endsection

@section('main_content')
    <div class="container-fluid">
        <div class="row">
        	<div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">My Appointment</h3>
                        <a href="{{ route('administration.appointment.create') }}" class="btn btn-info float-right">Create Appointment</a>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Serial</th>
                                    <th>Doctor</th>
                                    <th>Date</th>
                                    <th>Time</th>
                                    <th>Status</th>
                                    <th>Prescription</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($appointments as $key => $appointment)
                                    @php
                                        $prescription = \App\Models\Prescription\Prescription::where('appointment_id', $appointment->id)->first();
                                    @endphp
                                    <tr>
                                        <th>{{ serial($appointment, $key) }}</th>
                                        <td>{{ $appointment->doctor->user->name ?? 'N/A' }}</td>
                                        <td>{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('Y-m-d') }}</td>
                                        <td>{{ \Carbon\Carbon::parse($appointment->start_at)->format('h:i A') }} - {{ \Carbon\Carbon::parse($appointment->end_at)->format('h:i A') }}</td>
                                        <td>
                                            <span class="badge bg-{{ $appointment->status === 'confirmed' ? 'success' : ($appointment->status === 'pending' ? 'warning' : 'danger') }}">
                                                {{ ucfirst($appointment->status) }}
                                            </span>
                                        </td>
                                        <td>
                                            @if($prescription)
                                                <div class="d-flex flex-column">
                                                    <small class="text-success mb-1">
                                                        <i class="fas fa-check-circle me-1"></i>
                                                        Available
                                                    </small>
                                                    <div class="btn-group-sm">
                                                        <a href="{{ route('administration.prescriptions.show', $appointment->id) }}"
                                                           class="btn btn-outline-primary btn-sm me-1" title="View Prescription">
                                                            <i class="fas fa-eye"></i>
                                                        </a>
                                                        <a href="{{ route('administration.prescriptions.pdf', $appointment->id) }}"
                                                           class="btn btn-outline-secondary btn-sm" target="_blank" title="Download PDF">
                                                            <i class="fas fa-download"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                            @else
                                                <span class="text-muted">
                                                    <i class="fas fa-times-circle me-1"></i>
                                                    Not Available
                                                </span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">Options
                                                    <span class="sr-only">Toggle Dropdown</span>
                                                </button>
                                                <div class="dropdown-menu" role="menu">
                                                    @can('Appointment Update')
                                                        <a class="dropdown-item" href="{{ route('administration.appointment.edit', ['appointment' => $appointment]) }}"><i class="fas fa-edit"></i> Edit</a>
                                                    @endcan
                                                    
                                                    @can('Appointment Read')
                                                        <a class="dropdown-item" href="{{ route('administration.appointment.show', ['appointment' => $appointment]) }}"><i class="fas fa-eye"></i> Show</a>
                                                    @endcan
                                                    @can('Appointment Delete')
                                                        <a class="dropdown-item text-danger" href="#"
                                                        onclick="event.preventDefault(); confirmDelete('delete-form-permission-delete-{{ $appointment->id }}')">
                                                            <i class="fas fa-trash-alt"></i> Delete
                                                        </a>

                                                        <form id="delete-form-permission-delete-{{ $appointment->id }}" 
                                                            action="{{ route('administration.appointment.delete', ['appointment' => $appointment]) }}" 
                                                            method="POST" style="display:none;">
                                                            @csrf
                                                            @method('DELETE')
                                                        </form>
                                                    @endcan
                                                    
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">No appointments found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
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
    @include('admin.additionalObject.datatable-js')
@endsection

