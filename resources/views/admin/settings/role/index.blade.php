@extends('layouts.administration.app')
@section('title_content')
    {{config('app.name')}} || Roles
@endsection
@section('content_header')
    <div class="col-sm-6">
        <h1 class="m-0">{{__('Roles')}}</h1>
    </div><!-- /.col -->
    <!-- breadcrumb -->
    <x-ad-breadcrumb :items="[
        ['label' => 'Dashboard', 'url' => route('dashboard')],
        ['label' => 'Role & Permission', 'url' => route('administration.settings.rolepermission.role.index')],
        ['label' => 'Role '],
    ]" />
@endsection
@section('admin_vendor_css')
@endsection

@section('admin_page_css')
<style>
    .role-card {
        transition: transform 0.2s, box-shadow 0.2s;
        border: none;
        box-shadow: 0 2px 6px rgba(0,0,0,0.08);
    }
    .role-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }
    .avatar-group .avatar {
        margin-left: -0.8rem;
        border: 2px solid #fff;
        transition: transform 0.2s;
    }
    .avatar-group .avatar:hover {
        transform: scale(1.1);
        z-index: 2;
    }
    .role-stats {
        background: linear-gradient(45deg, #f8f9fa 30%, #ffffff 100%);
        border-radius: 8px;
        padding: 0.5rem 1rem;
    }
    .permission-badge {
        background: rgba(var(--bs-primary-rgb), 0.1);
        color: var(--bs-primary);
        font-size: 0.85rem;
        padding: 0.25rem 0.75rem;
        border-radius: 1rem;
    }
    .role-actions {
        opacity: 0.7;
        transition: opacity 0.2s;
    }
    .role-card:hover .role-actions {
        opacity: 1;
    }
    .add-role-card {
        background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
        min-height: 200px;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 2px dashed #dee2e6;
    }
    .add-role-card:hover {
        border-color: var(--bs-primary);
        background: linear-gradient(135deg, #ffffff 0%, #f0f9ff 100%);
    }
</style>
@endsection

@section('main_content')
    <div class="container-fluid">
        <div class="row g-4">
            @foreach ($roles as $role)
                <div class="col-xl-4 col-lg-6 col-md-6">
                    <div class="card role-card">
                        <div class="card-body p-4">
                            <div class="role-stats mb-3">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h6 class="fw-normal mb-0">
                                        <i class="ti ti-users text-primary me-2"></i>
                                        <strong>{{ $role->active_users_count }}</strong> Active Users
                                    </h6>
                                    <ul class="list-unstyled d-flex align-items-center avatar-group mb-0">
                                        @foreach ($role->users->take(5) as $user)
                                            <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" 
                                                title="{{ $user->alias_name }}" class="avatar avatar-sm pull-up">
                                                <span class="avatar-initial rounded-circle bg-label-hover-dark text-bold">
                                                    {{ profile_name_pic($user) }}
                                                </span>
                                            </li>
                                        @endforeach
                                        @if ($role->active_users_count > 5)
                                            <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" 
                                                title="{{ $role->active_users_count - 5 }} More" 
                                                class="avatar avatar-sm pull-up more-user-avatar">
                                                <span class="avatar-initial rounded-circle bg-light text-dark">
                                                    <small>{{ ($role->active_users_count - 5) < 10 ? $role->active_users_count - 5 : '9' }}+</small>
                                                </span>
                                            </li>
                                        @endif
                                    </ul>
                                </div>
                            </div>
                            
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div class="role-heading">
                                    <h4 class="mb-1">{{ $role->name }}</h4>
                                    <span class="permission-badge">
                                        <i class="ti ti-shield-check me-1"></i>
                                        {{ $role->permissions->count() }} Permissions
                                    </span>
                                </div>
                                <div class="role-actions">
                                    @if (auth()->user()->hasRole('Developer') || ($role->name !== 'Developer'))
                                        <a href="{{ route('administration.settings.rolepermission.role.edit', ['role' => $role]) }}" 
                                            class="btn btn-icon btn-outline-info btn-sm me-1" data-bs-toggle="tooltip" 
                                            data-popup="tooltip-custom" data-bs-placement="top" title="Edit Role">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                    @endif
                                    <a href="{{ route('administration.settings.rolepermission.role.show', ['role' => $role]) }}" 
                                        class="btn btn-icon btn-outline-primary btn-sm" data-bs-toggle="tooltip" 
                                        data-popup="tooltip-custom" data-bs-placement="top" title="Show Role Details">
                                        <i class="fa fa-info-circle"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach

            <div class="col-xl-4 col-lg-6 col-md-6">
                <div class="card role-card add-role-card">
                    <div class="card-body p-4 text-center">
                        <img src="{{ asset('assets/img/illustrations/add-new-roles.png') }}" 
                            class="img-fluid mb-4" alt="add-new-roles" width="120" />
                        <div>
                            <a href="{{ route('administration.settings.rolepermission.role.create') }}" 
                                class="btn btn-primary btn-lg mb-3">
                                <i class="ti ti-plus me-2"></i>
                                Add New Role
                            </a>
                            <p class="text-muted mb-0">Create a new role with custom permissions</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- /.container-fluid -->
    
@endsection
@section('admin_vendor_js')

    
@endsection

@section('admin_page_js')
@endsection
