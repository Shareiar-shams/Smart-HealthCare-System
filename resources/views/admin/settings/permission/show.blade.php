@extends('layouts.administration.app')
@section('title_content')
    {{config('app.name')}} || Permissions
@endsection
@section('content_header')
    <div class="col-sm-6">
        <h1 class="m-0">{{__('Permissions Details')}}</h1>
    </div><!-- /.col -->
    <!-- breadcrumb -->
    <x-ad-breadcrumb :items="[
        ['label' => 'Dashboard', 'url' => route('dashboard')],
        ['label' => 'Permissions', 'url' => route('administration.settings.rolepermission.permission.index')],
        ['label' => 'All Permissions'],
    ]" />
@endsection
@section('admin_vendor_css')
@endsection

@section('admin_page_css')
    <style>
        .permission-card {
            transition: all 0.3s ease;
            border: 1px solid #e9ecef;
        }
        .permission-card:hover {
            box-shadow: 0 0.125rem 0.25rem rgba(165, 163, 174, 0.3);
        }
        .permission-name {
            color: #566a7f;
            font-size: 1.1rem;
            position: relative;
            padding: 0.5rem 1rem;
            background: #f6f8fa;
            border-radius: 0.375rem;
            margin-bottom: 1rem;
        }
        .role-badge {
            transition: all 0.2s ease;
            font-size: 0.9rem;
            margin: 0.25rem;
            padding: 0.4rem 0.8rem;
            background: #fff;
            border: 1px solid #e9ecef;
            border-radius: 0.375rem;
            color: #697a8d;
            text-decoration: none;
            display: inline-block;
        }
        .role-badge:hover {
            border-color: #696cff;
            color: #696cff;
            box-shadow: 0 0.125rem 0.25rem rgba(105, 108, 255, 0.1);
        }
        .back-button:hover {
            background: #e9ecef;
        }
    </style>
@endsection

@section('main_content')
    <div class="container-fluid">
        <!-- Header with actions -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div class="d-flex align-items-center">
                <a href="{{ route('administration.settings.rolepermission.permission.index') }}" 
                   class="btn btn-icon btn-outline-secondary me-3 back-button">
                    <i class="fa fa-arrow-left"></i>
                </a>
                <div>
                    <h4 class="mb-1">{{ $module->name }}</h4>
                    <p class="text-muted mb-0">Permission Module Details</p>
                </div>
            </div>
            <div>
                <a href="#" class="btn btn-primary">
                    <i class="fa fa-edit me-2"></i>Edit Permissions
                </a>
            </div>
        </div>

        <!-- Permissions grid -->
        <div class="row">
            @foreach ($module->permissions as $permission)
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="permission-card rounded-3 p-3">
                    <div class="permission-name mb-3">
                        <i class="fa fa-lock-open me-2"></i>{{ $permission->name }}
                    </div>
                    
                    <div class="roles-section">
                        <div class="text-muted mb-2 small">
                            <i class="fa fa-users me-1"></i>Assigned Roles
                        </div>
                        <div class="roles-container">
                            @forelse ($permission->roles as $role)
                                <a href="{{ route('administration.settings.rolepermission.role.show', ['role' => $role]) }}" 
                                   class="role-badge">
                                    <i class="fa fa-user-shield me-1"></i>{{ $role->name }}
                                </a>
                            @empty
                                <span class="text-muted">No roles assigned</span>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        @if($module->permissions->isEmpty())
        <div class="text-center py-5">
            <div class="mb-3">
                <i class="fa fa-lock fa-3x text-muted"></i>
            </div>
            <h5>No Permissions Found</h5>
            <p class="text-muted">This module doesn't have any permissions assigned yet.</p>
            <a href="#" class="btn btn-primary">
                <i class="fa fa-plus me-2"></i>Add Permission
            </a>
        </div>
        @endif
    </div><!-- /.container-fluid -->
    
@endsection
@section('admin_vendor_js')

    
@endsection

@section('admin_page_js')
@endsection
