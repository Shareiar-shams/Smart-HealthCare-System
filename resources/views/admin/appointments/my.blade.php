@extends('layouts.administration.app')
@section('admin_title_content')
    AHVision | My Appointments
@endsection
@section('admin_content_header')
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
                                    <th>Notes</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($appointments as $key => $appointment)
                                    <tr>
                                        <th>{{ serial($appointment, $key) }}</th>
                                        <td>{{ $appointment->doctor->user->name ?? 'N/A' }}</td>
                                        <td>{{ Carbon::parse($a->date)->format('Y-m-d') }}</td>
                                        <td>{{ $appointment->time }}</td>
                                        <td>{{ ucfirst($appointment->status) }}</td>
                                        <td>{{ Str::limit($appointment->notes, 60) }}</td>
                                        <td>
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">Options
                                                    <span class="sr-only">Toggle Dropdown</span>
                                                </button>
                                                <div class="dropdown-menu" role="menu">
                                                    <a class="dropdown-item" href="javascript:void(0);"><i class="fas fa-edit"></i> Edit</a>

                                                    <a class="dropdown-item" href="{{ route('administration.appointment.show', $appointment->id) }}"><i class="fas fa-eye"></i> Show</a>

                                                    <a class="dropdown-item text-danger" href="#"
                                                    onclick="event.preventDefault(); confirmDelete('delete-form-permission-delete-{{ $appointment->id }}')">
                                                        <i class="fas fa-trash-alt"></i> Delete
                                                    </a>

                                                    <form id="delete-form-permission-delete-{{ $appointment->id }}" 
                                                        action="{{ route('administration.appointment.delete', $appointment->id) }}" 
                                                        method="POST" style="display:none;">
                                                        @csrf
                                                        @method('DELETE')
                                                    </form>
                                                    
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">Appointment found.</td>
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

