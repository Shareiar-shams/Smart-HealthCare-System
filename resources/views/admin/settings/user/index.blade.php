@extends('layouts.administration.app')
@section('admin_title_content')
    AHVision | Users
@endsection
@section('admin_content_header')
    <div class="col-sm-6">
        <h1 class="m-0">{{__('Users')}}</h1>
    </div><!-- /.col -->
    <!-- breadcrumb -->
    <x-ad-breadcrumb :items="[
        ['label' => 'Dashboard', 'url' => route('dashboard')],
        ['label' => 'Settings', 'url' => '#'],
        ['label' => 'Users'],
    ]" />
@endsection
@section('admin_vendor_css')
@endsection

@section('admin_page_css')
<style>
    .user-card {
        transition: transform 0.2s, box-shadow 0.2s;
        border: none;
        box-shadow: 0 2px 6px rgba(0,0,0,0.08);
    }
    .user-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }
    .user-avatar {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        font-weight: bold;
        color: white;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }
    .user-stats {
        background: linear-gradient(45deg, #f8f9fa 30%, #ffffff 100%);
        border-radius: 8px;
        padding: 0.5rem 1rem;
    }
    .role-badge {
        background: rgba(var(--bs-primary-rgb), 0.1);
        color: var(--bs-primary);
        font-size: 0.85rem;
        padding: 0.25rem 0.75rem;
        border-radius: 1rem;
    }
    .user-actions {
        opacity: 0.7;
        transition: opacity 0.2s;
    }
    .user-card:hover .user-actions {
        opacity: 1;
    }
    .add-user-card {
        background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
        min-height: 200px;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 2px dashed #dee2e6;
    }
    .add-user-card:hover {
        border-color: var(--bs-primary);
        background: linear-gradient(135deg, #ffffff 0%, #f0f9ff 100%);
    }
    .status-badge {
        font-size: 0.75rem;
        padding: 0.25rem 0.5rem;
    }
</style>
@endsection

@section('main_content')
    <div class="container-fluid">
        <div class="row g-4">
            @foreach ($users as $user)
                <div class="col-xl-4 col-lg-6 col-md-6">
                    <div class="card user-card">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-start mb-3">
                                <div class="user-avatar me-3">
                                    {{ strtoupper(substr($user->name, 0, 2)) }}
                                </div>
                                <div class="flex-grow-1">
                                    <h5 class="mb-1">{{ $user->name }}</h5>
                                    <p class="text-muted mb-2">{{ $user->email }}</p>
                                    @if($user->role)
                                        <span class="role-badge">
                                            <i class="fa fa-shield-check me-1"></i>
                                            {{ $user->role->name }}
                                        </span>
                                    @else
                                        <span class="badge bg-label-secondary">No Role</span>
                                    @endif
                                </div>
                                <div class="user-actions">
                                    @can('User Update')
                                        <a href="{{ route('administration.settings.user.edit', ['user' => $user]) }}" 
                                            class="btn btn-icon btn-outline-info btn-sm me-1" data-bs-toggle="tooltip" 
                                            data-popup="tooltip-custom" data-bs-placement="top" title="Edit User">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                    @endcan
                                    @can('User Read')
                                        <a href="{{ route('administration.settings.user.show.profile', ['user' => $user]) }}" 
                                            class="btn btn-icon btn-outline-primary btn-sm" data-bs-toggle="tooltip" 
                                            data-popup="tooltip-custom" data-bs-placement="top" title="View Profile">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                    @endcan
                                </div>
                            </div>
                            
                            <div class="user-stats">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <small class="text-muted d-block">Status</small>
                                        @if(isset($user->status))
                                            <span class="badge status-badge {{ $user->status === 'Active' ? 'bg-success' : 'bg-danger' }}">
                                                {{ $user->status }}
                                            </span>
                                        @else
                                            <span class="badge status-badge bg-success">Active</span>
                                        @endif
                                    </div>
                                    <div class="text-end">
                                        <small class="text-muted d-block">Joined</small>
                                        <strong>{{ $user->created_at->format('M d, Y') }}</strong>
                                    </div>
                                </div>
                            </div>

                            @can('User Delete')
                                @if($user->role->name !== 'Super Admin' && $user->role->name !== 'Admin' && $user->role->name !== 'Developer')
                                    <div class="mt-3">
                                        <a href="{{ route('administration.settings.user.destroy', ['user' => $user]) }}" 
                                            class="btn btn-sm btn-outline-danger w-100"
                                            onclick="return confirm('Are you sure you want to delete this user?')">
                                            <i class="fa fa-trash me-1"></i>
                                            Delete User
                                        </a>
                                    </div>
                                @endif
                            @endcan
                        </div>
                    </div>
                </div>
            @endforeach

            @can('User Create')
                <div class="col-xl-4 col-lg-6 col-md-6">
                    <div class="card user-card add-user-card">
                        <div class="card-body p-4 text-center">
                            <i class="fa fa-user-plus mb-3" style="font-size: 3rem; color: var(--bs-primary);"></i>
                            <div>
                                <a href="{{ route('administration.settings.user.create') }}" 
                                    class="btn btn-primary btn-lg mb-3">
                                    <i class="fa fa-plus me-2"></i>
                                    Add New User
                                </a>
                                <p class="text-muted mb-0">Create a new user account</p>
                            </div>
                        </div>
                    </div>
                </div>
            @endcan
        </div>
    </div><!-- /.container-fluid -->
    
@endsection
@section('admin_vendor_js')

    
@endsection

@section('admin_page_js')
@endsection
