@extends('layouts.administration.app')
@section('admin_title_content')
    {{config('app.name')}} || Create User
@endsection
@section('admin_content_header')
    <div class="col-sm-6">
        <h1 class="m-0">{{__('Create User')}}</h1>
    </div><!-- /.col -->
    <!-- breadcrumb -->
    <x-ad-breadcrumb :items="[
        ['label' => 'Dashboard', 'url' => route('dashboard')],
        ['label' => 'Users', 'url' => route('administration.settings.user.index')],
        ['label' => 'Create'],
    ]" />
@endsection
@section('admin_vendor_css')
@endsection

@section('admin_page_css')
<style>
    .form-section {
        background: #f8f9fa;
        padding: 1.5rem;
        border-radius: 8px;
        margin-bottom: 1.5rem;
    }
    .form-section-title {
        font-size: 1.1rem;
        font-weight: 600;
        margin-bottom: 1rem;
        color: #495057;
        border-bottom: 2px solid #dee2e6;
        padding-bottom: 0.5rem;
    }
    .required-field::after {
        content: " *";
        color: #dc3545;
    }
</style>
@endsection

@section('main_content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header header-elements">
                        <h5 class="mb-0">Create New User</h5>

                        <div class="card-header-elements float-right">
                            <a href="{{ route('administration.settings.user.index') }}" class="btn btn-sm btn-primary">
                                <span class="tf-icon fa fa-arrow-left ti-xs me-1"></span>
                                All Users
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('administration.settings.user.store') }}" method="post" autocomplete="off" id="userCreateForm">
                            @csrf

                            <!-- Basic Information Section -->
                            <div class="form-section">
                                <h6 class="form-section-title">
                                    <i class="fa fa-user me-2"></i>Basic Information
                                </h6>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label required-field" for="name">Full Name</label>
                                        <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror" 
                                            placeholder="Enter full name" value="{{ old('name') }}" required />
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label required-field" for="email">Email Address</label>
                                        <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror" 
                                            placeholder="Enter email address" value="{{ old('email') }}" required />
                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Security Section -->
                            <div class="form-section">
                                <h6 class="form-section-title">
                                    <i class="fa fa-lock me-2"></i>Security
                                </h6>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label required-field" for="password">Password</label>
                                        <div class="input-group">
                                            <input type="password" id="password" name="password" 
                                                class="form-control @error('password') is-invalid @enderror" 
                                                placeholder="Enter password" required />
                                            <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                                <i class="fa fa-eye" id="togglePasswordIcon"></i>
                                            </button>
                                        </div>
                                        @error('password')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                        <small class="text-muted">Minimum 8 characters</small>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label required-field" for="password_confirmation">Confirm Password</label>
                                        <div class="input-group">
                                            <input type="password" id="password_confirmation" name="password_confirmation" 
                                                class="form-control @error('password_confirmation') is-invalid @enderror" 
                                                placeholder="Confirm password" required />
                                            <button class="btn btn-outline-secondary" type="button" id="togglePasswordConfirm">
                                                <i class="fa fa-eye" id="togglePasswordConfirmIcon"></i>
                                            </button>
                                        </div>
                                        @error('password_confirmation')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Role Assignment Section -->
                            <div class="form-section">
                                <h6 class="form-section-title">
                                    <i class="fa fa-shield-check me-2"></i>Role Assignment
                                </h6>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label" for="role_id">Assign Role</label>
                                        <select id="role_id" name="role_id" class="form-select @error('role_id') is-invalid @enderror">
                                            <option value="">Select a role</option>
                                            @foreach($roles as $role)
                                                <option value="{{ $role->id }}" {{ old('role_id') == $role->id ? 'selected' : '' }}>
                                                    {{ $role->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('role_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <small class="text-muted">Optional: Assign a role to this user</small>
                                    </div>
                                </div>
                            </div>

                            <!-- Form Actions -->
                            <div class="row mt-4">
                                <div class="col-12">
                                    <div class="d-flex justify-content-between">
                                        <a href="{{ route('administration.settings.user.index') }}"
                                        class="btn btn-secondary">
                                            <span class="tf-icon fa fa-x ti-xs me-1"></span>
                                            Cancel
                                        </a>
                                        <button type="submit" class="btn btn-primary" id="submitBtn">
                                            <span class="tf-icon fa fa-check ti-xs me-1"></span>
                                            Create User
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('admin_vendor_js')
    <script src="{{ asset('assets/plugins/toastr/toastr.min.js')}}"></script>
@endsection

@section('admin_page_js')
    <script>
        $(document).ready(function () {
            // Toggle password visibility
            $('#togglePassword').click(function() {
                const passwordField = $('#password');
                const icon = $('#togglePasswordIcon');
                
                if (passwordField.attr('type') === 'password') {
                    passwordField.attr('type', 'text');
                    icon.removeClass('ti-eye').addClass('ti-eye-off');
                } else {
                    passwordField.attr('type', 'password');
                    icon.removeClass('ti-eye-off').addClass('ti-eye');
                }
            });

            // Toggle password confirmation visibility
            $('#togglePasswordConfirm').click(function() {
                const passwordField = $('#password_confirmation');
                const icon = $('#togglePasswordConfirmIcon');
                
                if (passwordField.attr('type') === 'password') {
                    passwordField.attr('type', 'text');
                    icon.removeClass('ti-eye').addClass('ti-eye-off');
                } else {
                    passwordField.attr('type', 'password');
                    icon.removeClass('ti-eye-off').addClass('ti-eye');
                }
            });

            // Form submission with loading state
            $('#userCreateForm').submit(function(e) {
                const password = $('#password').val();
                const passwordConfirm = $('#password_confirmation').val();

                if (password !== passwordConfirm) {
                    e.preventDefault();
                    toastr.error('Passwords do not match!');
                    return false;
                }

                if (password.length < 8) {
                    e.preventDefault();
                    toastr.error('Password must be at least 8 characters long!');
                    return false;
                }

                $('#submitBtn').addClass('loading').prop('disabled', true);
            });
        });
    </script>
@endsection
