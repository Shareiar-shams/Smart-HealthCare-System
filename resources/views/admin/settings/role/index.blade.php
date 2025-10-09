@extends('layouts.administration.app')
@section('admin_title_content')
    AHVision | Roles
@endsection
@section('admin_content_header')
    <div class="col-sm-6">
        <h1 class="m-0">{{__('Roles')}}</h1>
    </div><!-- /.col -->
    <!-- breadcrumb -->
    <x-ad-breadcrumb :items="[
        ['label' => 'Dashboard', 'url' => route('dashboard')],
        ['label' => 'Roles', 'url' => route('administration.settings.rolepermission.role.index')],
        ['label' => 'All Roles'],
    ]" />
@endsection
@section('admin_vendor_css')
@endsection

@section('admin_page_css')
@endsection

@section('main_content')
    <div class="container-fluid">
        <div class="row">
        	@foreach ($roles as $role)
                <div class="col-xl-4 col-lg-6 col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <h6 class="fw-normal mb-2">Total <strong>{{ $role->active_users_count }}</strong> Active Users</h6>
                                <ul class="list-unstyled d-flex align-items-center avatar-group mb-0">
                                    @foreach ($role->users->take(5) as $user)
                                        <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" title="{{ $user->alias_name }}" class="avatar avatar-sm pull-up">
                                            @if ($user->hasMedia('avatar'))
                                                <img src="{{ $user->getFirstMediaUrl('avatar', 'thumb') }}" alt="Avatar" class="rounded-circle">
                                            @else
                                                <span class="avatar-initial rounded-circle bg-label-hover-dark text-bold">
                                                    {{ profile_name_pic($user) }}
                                                </span>
                                            @endif
                                        </li>
                                    @endforeach
                                    @if ($role->active_users_count > 5)
                                        <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" title="{{ $role->active_users_count - 5 }} More" class="avatar avatar-sm pull-up more-user-avatar">
                                            <small>{{ ($role->active_users_count - 5) < 10 ? $role->active_users_count - 5 : '9' }}+</small>
                                        </li>
                                    @endif
                                </ul>
                            </div>
                            <div class="d-flex justify-content-between align-items-end mt-1">
                                <div class="role-heading">
                                    <h4 class="mb-1">{{ $role->name }}</h4>
                                    <span class="role-edit-modal">
                                        <span>Total Permissions: <strong>{{ $role->permissions->count() }}</strong></span>
                                    </span>
                                </div>
                                <div>
                                    @if (auth()->user()->hasRole('Developer') || ($role->name !== 'Developer' && $role->name !== 'Super Admin'))
                                        <a href="{{ route('administration.settings.rolepermission.role.edit', ['role' => $role]) }}" class="text-muted" data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" title="Edit Role">
                                            <i class="ti ti-edit ti-md text-info"></i>
                                        </a>
                                    @endif

                                    <a href="{{ route('administration.settings.rolepermission.role.show', ['role' => $role]) }}" class="text-muted" data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" title="Show Role Details">
                                        <i class="ti ti-info-hexagon ti-md text-primary"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach

            <div class="col-xl-4 col-lg-6 col-md-6">
                <div class="card h-100">
                    <div class="row h-100">
                        <div class="col-sm-5">
                            <div class="d-flex align-items-end h-100 justify-content-center mt-sm-0 mt-3">
                                <img src="{{ asset('assets/img/illustrations/add-new-roles.png') }}" class="img-fluid mt-sm-4 mt-md-0" alt="add-new-roles" width="83" />
                            </div>
                        </div>
                        <div class="col-sm-7">
                            <div class="card-body text-sm-end text-center ps-sm-0">
                                <a href="{{ route('administration.settings.rolepermission.role.create') }}" class="btn btn-primary mb-2 text-nowrap add-new-role">
                                    Add New Role
                                </a>
                                <p class="mb-0 mt-1">Add role, if it does not exist</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
    
@endsection
@section('admin_vendor_js')

    
@endsection

@section('admin_page_js')
@endsection
