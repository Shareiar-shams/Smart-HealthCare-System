@extends('layouts.auth.app')

@section('meta_tags')
    <meta name="description" content="register Page">
    <meta name="keywords" content="register, authentication, user register">
    <meta name="author" content="Smart HealthCare">
@endsection

@section('page_title', 'Registration')
@section('body_class', 'register-page')

@section('page_styles')
    
@endsection

@section('content')
    <div class="register-box">
        <!-- /.register-logo -->
        <div class="card card-outline card-primary">
            <div class="card-header text-center">
                <h4 class="h1"><b>{{config('app.name')}} </b>HealthCare</h4>
                {{-- <img src="{{ asset(config('app.logo')) }}" alt="logo" height="50" class="mb-2"/> --}}
            </div>
            <div class="card-body">
                <p class="register-box-msg">{{ __('Register a new membership') }}</p>

                <form method="POST" action="{{ route('register') }}">
                    @csrf
                    <div class="input-group mb-3">
                        <select name="role" id="role" class="form-control select2 @error('role') is-invalid @enderror" required>
                            <option value="">{{ __('Select Role') }}</option>
                            @foreach($roles as $role)
                                <option value="{{ $role->id }}--{{ $role->name }}" {{ (old('role') == $role->name) ? 'selected' : '' }}>{{ ucfirst($role->name) }}</option>
                            @endforeach
                        </select>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-user-tag"></span>
                            </div>
                        </div>

                        @error('role')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="input-group mb-3"> 
                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus placeholder="User Name">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-user"></span>
                            </div>
                        </div>
                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="input-group mb-3">
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" placeholder="Email" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>

                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="input-group mb-3">
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="Password" required autocomplete="current-password">

                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>

                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="input-group mb-3">
                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password" placeholder="Retype password">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    
                    {{-- User Fields --}}
                    {{-- Common Profile Fields --}}
                    <div id="common-fields" style="display:none;">
                        @include('auth.registerPartials_.common_fields')
                    </div>

                    {{-- Doctor Fields --}}
                    <div id="doctor-fields" style="display:none;">
                        @include('auth.registerPartials_.doctor_fields')
                    </div>

                    {{-- Pharmacy Fields --}}
                    <div id="pharmacy-fields" style="display:none;">
                        @include('auth.registerPartials_.pharmacy_fields')
                    </div>

                    <div class="row">
                        <div class="col-8">
                            <div class="icheck-primary">
                                <input type="checkbox" id="agreeTerms" name="terms" value="agree">
                                <label for="agreeTerms">
                                    I agree to the <a href="#">terms</a>
                                </label>
                            </div>
                        </div>
                        <!-- /.col -->
                        <div class="col-4">
                            <button type="submit" class="btn btn-primary btn-block">{{ __('Sign Up') }}</button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>
                
                <p class="mb-0">
                    <a href="{{ route('login') }}" class="text-center">{{ __('Already have an account') }}</a>
                </p>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
        </div>
        <!-- /.register-box -->
@endsection

@section('page_js')
    <script>
        $(document).ready(function() {
            $('#role').change(function() {
                var selectedRole = $(this).val().split('--')[1];
                var roleName = selectedRole ? selectedRole.toLowerCase() : '';
                console.log("Selected Role: " + selectedRole); // Debugging line
                
                // Hide role-specific fields initially
                $('#doctor-fields, #pharmacy-fields').hide();

                // Show fields based on selected role
                if (roleName === 'doctor') {
                    $('#doctor-fields').show();
                } else if (roleName === 'pharmacy') {
                    $('#pharmacy-fields').show();
                } else if( roleName === 'patient'){
                    $('#common-fields').show();
                } else {
                    // If no specific role is selected, hide all role-specific fields
                    $('#doctor-fields, #pharmacy-fields').hide();
                }
            });
        });
    </script>
@endsection

