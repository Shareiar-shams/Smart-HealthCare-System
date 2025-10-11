@extends('layouts.administration.app')
@section('admin_title_content')
    {{config('app.name')}} || User Profile
@endsection
@section('admin_content_header')
    <div class="col-sm-6">
        <h1 class="m-0">{{__('User Profile')}}</h1>
    </div><!-- /.col -->
    <!-- breadcrumb -->
    <x-ad-breadcrumb :items="[
        ['label' => 'Dashboard', 'url' => route('dashboard')],
        ['label' => 'Users', 'url' => route('administration.settings.user.index')],
        ['label' => 'Profile'],
    ]" />
@endsection
@section('admin_vendor_css')
@endsection

@section('admin_page_css')
<style>
    .profile-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 2rem;
        border-radius: 8px 8px 0 0;
    }
    .profile-avatar {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2.5rem;
        font-weight: bold;
        background: rgba(255, 255, 255, 0.2);
        border: 4px solid white;
    }
    .info-card {
        border-left: 4px solid var(--bs-primary);
    }
    .stat-card {
        background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);
        border-radius: 8px;
        padding: 1.5rem;
        text-align: center;
        transition: transform 0.2s;
    }
    .stat-card:hover {
        transform: translateY(-5px);
    }
    .stat-icon {
        font-size: 2rem;
        margin-bottom: 0.5rem;
    }
    .card {
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        transition: all 0.3s ease;
    }
    .card:hover {
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
    }
    .badge {
        font-weight: 500;
        letter-spacing: 0.3px;
    }
    .bg-label-primary {
        background-color: rgba(var(--bs-primary-rgb), 0.1);
        color: var(--bs-primary);
    }
    .bg-label-success {
        background-color: rgba(var(--bs-success-rgb), 0.1);
        color: var(--bs-success);
    }
    .bg-label-danger {
        background-color: rgba(var(--bs-danger-rgb), 0.1);
        color: var(--bs-danger);
    }
    .bg-label-info {
        background-color: rgba(var(--bs-info-rgb), 0.1);
        color: var(--bs-info);
    }
    .card-header.bg-primary {
        background: linear-gradient(135deg, #4e73df 0%, #224abe 100%) !important;
    }
    .card-header.bg-info {
        background: linear-gradient(135deg, #36b9cc 0%, #258391 100%) !important;
    }
    .form-label {
        font-size: 0.875rem;
        margin-bottom: 0.25rem;
    }
    .fw-semibold {
        font-size: 1rem;
    }
    .card.bg-light {
        background-color: #f8f9fa !important;
        border: 1px solid #e9ecef;
    }
</style>
@endsection

@section('main_content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <!-- Profile Header Card -->
                <div class="card mb-4">
                    <div class="card-header header-elements">
                        <div class="card-header-elements float-right">
                            <a href="{{ route('administration.settings.user.index') }}" class="btn btn-sm btn-primary">
                                <span class="tf-icon fa fa-arrow-left ti-xs me-1"></span>
                                All Users
                            </a>
                        </div>
                    </div>
                    <div class="profile-header">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center">
                                <div class="profile-avatar me-4">
                                    {{ strtoupper(substr($user->name, 0, 2)) }}
                                </div>
                                <div>
                                    <h3 class="mb-1">{{ $user->name }}</h3>
                                    <p class="mb-2">{{ $user->email }}</p>
                                    @if($user->role)
                                        <span class="badge bg-white text-primary">
                                            <i class="fa fa-shield-check me-1"></i>
                                            {{ $user->role->name }}
                                        </span>
                                    @endif
                                </div>
                            </div>
                            @can('User Update')
                                <a href="{{ route('administration.settings.user.edit', $user) }}" class="btn btn-light">
                                    <i class="fa fa-edit me-1"></i> Edit Profile
                                </a>
                            @endcan
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-3">
                                <div class="stat-card">
                                    <div class="stat-icon text-primary">
                                        <i class="fa fa-shield-check"></i>
                                    </div>
                                    <h4 class="mb-0">{{ $statistics['role_count'] }}</h4>
                                    <small class="text-muted">Assigned Roles</small>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="stat-card">
                                    <div class="stat-icon text-success">
                                        <i class="fa fa-key"></i>
                                    </div>
                                    <h4 class="mb-0">{{ $statistics['permission_count'] }}</h4>
                                    <small class="text-muted">Permissions</small>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="stat-card">
                                    <div class="stat-icon text-info">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <h4 class="mb-0">{{ $statistics['created_at']->format('M d, Y') }}</h4>
                                    <small class="text-muted">Member Since</small>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="stat-card">
                                    <div class="stat-icon {{ $statistics['status'] === 'Active' ? 'text-success' : 'text-danger' }}">
                                        <i class="fa fa-circle-check"></i>
                                    </div>
                                    <h4 class="mb-0">{{ $statistics['status'] }}</h4>
                                    <small class="text-muted">Account Status</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- User Information Card -->
                <div class="card mb-4 info-card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="fa fa-info-circle me-2"></i>User Information
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-muted">Full Name</label>
                                <p class="fw-semibold">{{ $user->name }}</p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-muted">Email Address</label>
                                <p class="fw-semibold">{{ $user->email }}</p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-muted">Role</label>
                                <p class="fw-semibold">
                                    @if($user->role)
                                        <span class="badge bg-label-primary">{{ $user->role->name }}</span>
                                    @else
                                        <span class="badge bg-label-secondary">No Role Assigned</span>
                                    @endif
                                </p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-muted">Account Status</label>
                                <p class="fw-semibold">
                                    <span class="badge {{ $statistics['status'] === 'Active' ? 'bg-success' : 'bg-danger' }}">
                                        {{ $statistics['status'] }}
                                    </span>
                                </p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-muted">Created At</label>
                                <p class="fw-semibold">{{ $user->created_at->format('F d, Y h:i A') }}</p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-muted">Last Updated</label>
                                <p class="fw-semibold">{{ $user->updated_at->format('F d, Y h:i A') }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Roles & Permissions Card -->
                @if($user->roles->count() > 0)
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                <i class="fa fa-shield-check me-2"></i>Roles & Permissions
                            </h5>
                        </div>
                        <div class="card-body">
                            <h6 class="mb-3">Assigned Roles:</h6>
                            <div class="d-flex flex-wrap gap-2 mb-4">
                                @foreach($user->roles as $role)
                                    <span class="badge bg-label-primary">{{ $role->name }}</span>
                                @endforeach
                            </div>

                            <h6 class="mb-3">Permissions:</h6>
                            <div class="d-flex flex-wrap gap-2">
                                @forelse($user->getAllPermissions() as $permission)
                                    <span class="badge bg-label-success">{{ $permission->name }}</span>
                                @empty
                                    <p class="text-muted mb-0">No permissions assigned.</p>
                                @endforelse
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Profile Information Card -->
                @if($user->profile)
                    <div class="card mb-4">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="card-title mb-0">
                                <i class="fa fa-user-circle me-2"></i>Profile Details
                            </h5>
                            <span class="badge bg-info">{{ ucfirst($user->role->name ?? 'User') }} Profile</span>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label text-muted">Phone Number</label>
                                    <p class="fw-semibold">{{ $user->profile->phone ?? 'N/A' }}</p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label text-muted">Address</label>
                                    <p class="fw-semibold">{{ $user->profile->address ?? 'N/A' }}</p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label text-muted">City</label>
                                    <p class="fw-semibold">{{ $user->profile->city ?? 'N/A' }}</p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label text-muted">State</label>
                                    <p class="fw-semibold">{{ $user->profile->state ?? 'N/A' }}</p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label text-muted">Postal Code</label>
                                    <p class="fw-semibold">{{ $user->profile->postal_code ?? 'N/A' }}</p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label text-muted">Gender</label>
                                    <p class="fw-semibold">
                                        <span class="badge bg-label-{{ $user->profile->gender == 'male' ? 'primary' : ($user->profile->gender == 'female' ? 'danger' : 'secondary') }}">
                                            {{ ucfirst($user->profile->gender ?? 'Not Specified') }}
                                        </span>
                                    </p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label text-muted">Blood Group</label>
                                    <p class="fw-semibold">
                                        <span class="badge bg-label-danger">
                                            {{ $user->profile->blood_group ?? 'Not Specified' }}
                                        </span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Doctor Information -->
                @if($user->doctor)
                    <div class="card mb-4">
                        <div class="card-header bg-primary text-white">
                            <h5 class="card-title mb-0">
                                <i class="fa fa-stethoscope me-2"></i>Professional Information
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label text-muted">Specialty</label>
                                    <p class="fw-semibold">{{ $user->doctor->specialty ?? 'N/A' }}</p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label text-muted">Qualification</label>
                                    <p class="fw-semibold">{{ $user->doctor->qualification ?? 'N/A' }}</p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label text-muted">Experience</label>
                                    <p class="fw-semibold">{{ $user->doctor->experience_years ?? '0' }} Years</p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label text-muted">License Number</label>
                                    <p class="fw-semibold">{{ $user->doctor->license_number ?? 'N/A' }}</p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label text-muted">Consultation Fee</label>
                                    <p class="fw-semibold">
                                        <span class="badge bg-success">
                                            ${{ number_format($user->doctor->consultation_fee ?? 0, 2) }}
                                        </span>
                                    </p>
                                </div>
                                <div class="col-12 mb-3">
                                    <label class="form-label text-muted">Professional Bio</label>
                                    <div class="card bg-light">
                                        <div class="card-body">
                                            {{ $user->doctor->bio ?? 'No bio available.' }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Pharmacy Information -->
                @if($user->pharmacy)
                    <div class="card mb-4">
                        <div class="card-header bg-info text-white">
                            <h5 class="card-title mb-0">
                                <i class="fa fa-building-hospital me-2"></i>Pharmacy Information
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label text-muted">Pharmacy Name</label>
                                    <p class="fw-semibold">{{ $user->pharmacy->pharmacy_name ?? 'N/A' }}</p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label text-muted">License Number</label>
                                    <p class="fw-semibold">{{ $user->pharmacy->license_number ?? 'N/A' }}</p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label text-muted">Services</label>
                                    <div>
                                        @if($user->pharmacy->delivery_available)
                                            <span class="badge bg-success me-2">
                                                <i class="fa fa-truck me-1"></i> Delivery Available
                                            </span>
                                        @endif
                                        @if($user->pharmacy->emergency_service)
                                            <span class="badge bg-danger">
                                                <i class="fa fa-ambulance me-1"></i> Emergency Service
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-12 mb-3">
                                    <label class="form-label text-muted">Description</label>
                                    <div class="card bg-light">
                                        <div class="card-body">
                                            {{ $user->pharmacy->description ?? 'No description available.' }}
                                        </div>
                                    </div>
                                </div>

                                <!-- Operating Hours or Additional Services can be added here -->
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@section('admin_vendor_js')
@endsection

@section('admin_page_js')
@endsection
