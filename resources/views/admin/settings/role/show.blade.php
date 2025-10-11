@extends('layouts.administration.app')
@section('admin_title_content')
    {{config('app.name')}} || Roles
@endsection
@section('admin_content_header')
    <div class="col-sm-6">
        <h1 class="m-0">{{__('Roles Details')}}</h1>
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
@endsection

@section('main_content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div>
                                <h4 class="mb-1">{{ $role->name }}</h4>
                                <span class="d-block">Created: {{ $role->created_at->format('M d, Y') }}</span>
                            </div>
                            @if(auth()->user()->hasRole('Developer') || (!in_array($role->name, ['Developer', 'Super Admin'])))
                                <a href="{{ route('administration.settings.rolepermission.role.edit', $role) }}" class="btn btn-primary">
                                    <i class="fa fa-edit me-1"></i> Edit Role
                                </a>
                            @endif
                            <div class="card-header-elements ms-auto">
                                <a href="{{ route('administration.settings.rolepermission.role.index') }}" class="btn btn-sm btn-primary">
                                    <span class="tf-icon fa fa-arrow-left ti-xs me-1"></span>
                                    Back
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Role Permissions</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-flush-spacing">
                                <tbody>
                                    @foreach($permissionModules as $module)
                                        <tr>
                                            <td class="text-nowrap fw-semibold" style="width: 200px;">
                                                {{ $module->name }}
                                                <i class="fa fa-info-circle" data-bs-toggle="tooltip" 
                                                    data-bs-placement="top" 
                                                    title="{{ $module->description }}">
                                                </i>
                                            </td>
                                            <td>
                                                <div class="d-flex flex-wrap gap-2">
                                                    @foreach($module->permissions as $permission)
                                                        @if($role->hasPermissionTo($permission))
                                                            <span class="badge bg-label-primary">
                                                                {{ $permission->name }}
                                                            </span>
                                                        @endif
                                                    @endforeach
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="card mt-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Users with this Role</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex flex-wrap gap-2">
                            @forelse($role->users->take(20) as $user)
                                <span class="badge bg-label-dark">{{ $user->name }}</span>
                            @empty
                                <p class="text-muted mb-0">No users assigned to this role.</p>
                            @endforelse
                            @if($role->users->count() > 20)
                                <span class="badge bg-label-secondary">+{{ $role->users->count() - 20 }} more</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('admin_vendor_js')
@endsection
@section('admin_page_js')
@endsection