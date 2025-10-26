@extends('layouts.administration.app')
@section('title_content')
    {{config('app.name')}} || Permissions
@endsection
@section('content_header')
    <div class="col-sm-6">
        <h1 class="m-0">{{__('Permissions')}}</h1>
    </div><!-- /.col -->
    <!-- breadcrumb -->
    <x-ad-breadcrumb :items="[
        ['label' => 'Dashboard', 'url' => route('dashboard')],
        ['label' => 'Permissions', 'url' => route('administration.settings.rolepermission.permission.index')],
        ['label' => 'All Permissions'],
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
                        <h3 class="card-title">All Permissions</h3>
                        <a href="{{ route('administration.settings.rolepermission.permission.create') }}" class="btn btn-info float-right">Create Permission</a>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Sl.</th>
                                    <th>Module</th>
                                    <th>Permissions</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($modules as $key => $module)
                                    <tr>
                                        <th>{{ serial($modules, $key) }}</th>
                                        <td>{{ $module->name }}</td>
                                        <td>
                                            @foreach ($module->permissions as $permission)
                                                <span class="badge bg-label-primary">{{ $permission->name }}</span>
                                            @endforeach
                                        </td>
                                        <td>
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">Options
                                                    <span class="sr-only">Toggle Dropdown</span>
                                                </button>
                                                <div class="dropdown-menu" role="menu">
                                                    <a class="dropdown-item" href="javascript:void(0);"><i class="fas fa-edit"></i> Edit</a>

                                                    <a class="dropdown-item" href="{{ route('administration.settings.rolepermission.permission.module.show', ['module' => $module]) }}"><i class="fas fa-eye"></i> Show</a>

                                                    <a class="dropdown-item text-danger" href="#"
                                                    onclick="event.preventDefault(); confirmDelete('delete-form-permission-delete-{{ $module->id }}')">
                                                        <i class="fas fa-trash-alt"></i> Delete
                                                    </a>

                                                    <form id="delete-form-permission-delete-{{ $module->id }}" 
                                                        action="{{ route('administration.settings.rolepermission.permission.delete', ['module' => $module]) }}" 
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
                                        <td colspan="4" class="text-center">No activity found.</td>
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
