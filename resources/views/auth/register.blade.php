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
                <h4 class="h1"><b>Smart </b>HealthCare</h4>
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
                    <div id="common-fields">
                        <div class="input-group mb-3">
                            <input id="phone" type="text" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone') }}" required placeholder="Phone Number">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-phone"></span>
                                </div>
                            </div>
                            @error('phone')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="input-group mb-3">
                            <input id="address" type="text" class="form-control @error('address') is-invalid @enderror" name="address" value="{{ old('address') }}" required placeholder="Address">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-map-marker-alt"></span>
                                </div>
                            </div>
                            @error('address')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="input-group mb-3">
                            <input id="city" type="text" class="form-control @error('city') is-invalid @enderror" name="city" value="{{ old('city') }}" required placeholder="City">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-city"></span>
                                </div>
                            </div>
                            @error('city')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="input-group mb-3">
                            <input id="state" type="text" class="form-control @error('state') is-invalid @enderror" name="state" value="{{ old('state') }}" required placeholder="State">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-map"></span>
                                </div>
                            </div>
                            @error('state')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="input-group mb-3">
                            <input id="postal_code" type="text" class="form-control @error('postal_code') is-invalid @enderror" name="postal_code" value="{{ old('postal_code') }}" required placeholder="Postal Code">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-mail-bulk"></span>
                                </div>
                            </div>
                            @error('postal_code')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="input-group mb-3">
                            <select id="gender" name="gender" class="form-control @error('gender') is-invalid @enderror" required>
                                <option value="">Select Gender</option>
                                <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
                                <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
                                <option value="other" {{ old('gender') == 'other' ? 'selected' : '' }}>Other</option>
                            </select>
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-venus-mars"></span>
                                </div>
                            </div>
                            @error('gender')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="input-group mb-3">
                            <select id="blood_group" name="blood_group" class="form-control @error('blood_group') is-invalid @enderror" required>
                                <option value="">Select Blood Group</option>
                                @foreach (['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'] as $blood)
                                    <option value="{{ $blood }}" {{ old('blood_group') == $blood ? 'selected' : '' }}>{{ $blood }}</option>
                                @endforeach
                            </select>
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-tint"></span>
                                </div>
                            </div>
                            @error('blood_group')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    {{-- Doctor Fields --}}
                    <div id="doctor-fields" style="display:none;">
                        <hr>
                        <h5 class="mb-3">Professional Information</h5>
                        <div class="input-group mb-3">
                            <input id="specialty" type="text" class="form-control @error('specialty') is-invalid @enderror" name="specialty" value="{{ old('specialty') }}" placeholder="Specialty">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-stethoscope"></span>
                                </div>
                            </div>
                            @error('specialty')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="input-group mb-3">
                            <input id="qualification" type="text" class="form-control @error('qualification') is-invalid @enderror" name="qualification" value="{{ old('qualification') }}" placeholder="Qualification">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-graduation-cap"></span>
                                </div>
                            </div>
                            @error('qualification')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="input-group mb-3">
                            <input id="experience_years" type="number" class="form-control @error('experience_years') is-invalid @enderror" name="experience_years" value="{{ old('experience_years') }}" placeholder="Years of Experience">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-clock"></span>
                                </div>
                            </div>
                            @error('experience_years')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="input-group mb-3">
                            <input id="license_number" type="text" class="form-control @error('license_number') is-invalid @enderror" name="license_number" value="{{ old('license_number') }}" placeholder="License Number">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-id-card"></span>
                                </div>
                            </div>
                            @error('license_number')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="input-group mb-3">
                            <input id="consultation_fee" type="number" step="0.01" class="form-control @error('consultation_fee') is-invalid @enderror" name="consultation_fee" value="{{ old('consultation_fee') }}" placeholder="Consultation Fee">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-dollar-sign"></span>
                                </div>
                            </div>
                            @error('consultation_fee')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="input-group mb-3">
                            <textarea id="bio" name="bio" class="form-control @error('bio') is-invalid @enderror" rows="3" placeholder="Professional Bio">{{ old('bio') }}</textarea>
                            @error('bio')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    {{-- Pharmacy Fields --}}
                    <div id="pharmacy-fields" style="display:none;">
                        <hr>
                        <h5 class="mb-3">Pharmacy Information</h5>
                        <div class="input-group mb-3">
                            <input id="pharmacy_name" type="text" class="form-control @error('pharmacy_name') is-invalid @enderror" name="pharmacy_name" value="{{ old('pharmacy_name') }}" placeholder="Pharmacy Name">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-clinic-medical"></span>
                                </div>
                            </div>
                            @error('pharmacy_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="input-group mb-3">
                            <input id="license_number" type="text" class="form-control @error('license_number') is-invalid @enderror" name="license_number" value="{{ old('license_number') }}" placeholder="License Number">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-id-card"></span>
                                </div>
                            </div>
                            @error('license_number')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="input-group mb-3">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="delivery_available" name="delivery_available" {{ old('delivery_available') ? 'checked' : '' }}>
                                <label class="form-check-label" for="delivery_available">Delivery Available</label>
                            </div>
                        </div>

                        <div class="input-group mb-3">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="emergency_service" name="emergency_service" {{ old('emergency_service') ? 'checked' : '' }}>
                                <label class="form-check-label" for="emergency_service">Emergency Service Available</label>
                            </div>
                        </div>

                        <div class="input-group mb-3">
                            <textarea id="description" name="description" class="form-control @error('description') is-invalid @enderror" rows="3" placeholder="Pharmacy Description">{{ old('description') }}</textarea>
                            @error('description')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>                    {{-- Doctor Fields --}}
                    <div id="doctor-fields" style="display:none;">
                        <div class="input-group mb-3">
                            <input id="registration_no" type="text" class="form-control @error('registration_no') is-invalid @enderror" name="registration_no" value="{{ old('registration_no') }}" placeholder="Medical Registration Number">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-id-card"></span>
                                </div>
                            </div>

                            @error('registration_no')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="input-group mb-3">
                            <input id="specialization" type="text" class="form-control @error('specialization') is-invalid @enderror" name="specialization" value="{{ old('specialization') }}" placeholder="Specialization">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-user-md"></span>
                                </div>
                            </div>

                            @error('specialization')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="input-group mb-3">
                            <input id="hospital_name" type="text" class="form-control @error('hospital_name') is-invalid @enderror" name="hospital_name" value="{{ old('hospital_name') }}" placeholder="Hospital/Clinic Name">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-hospital"></span>
                                </div>
                            </div>

                            @error('hospital_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="input-group mb-3">
                            <input id="chamber_address" type="text" class="form-control @error('chamber_address') is-invalid @enderror" name="chamber_address" value="{{ old('chamber_address') }}" placeholder="Chamber Address">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-map-marker-alt"></span>
                                </div>
                            </div>

                            @error('chamber_address')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="input-group mb-3">
                            <input id="available_time" type="text" class="form-control @error('available_time') is-invalid @enderror" name="available_time" value="{{ old('available_time') }}" placeholder="Available Time Slots">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-clock"></span>
                                </div>
                            </div>

                            @error('available_time')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    {{-- Pharmacy Fields --}}
                    <div id="pharmacy-fields" style="display:none;">
                        <div class="input-group mb-3">
                            <input id="pharmacy_name" type="text" class="form-control @error('pharmacy_name') is-invalid @enderror" name="pharmacy_name" value="{{ old('pharmacy_name') }}" placeholder="Pharmacy Name">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-store"></span>
                                </div>
                            </div>

                            @error('pharmacy_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="input-group mb-3">
                            <input id="owner_name" type="text" class="form-control @error('owner_name') is-invalid @enderror" name="owner_name" value="{{ old('owner_name') }}" placeholder="Owner Name">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-user"></span>
                                </div>
                            </div>

                            @error('owner_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="input-group mb-3">
                            <input id="location" type="text" class="form-control @error('location') is-invalid @enderror" name="location" value="{{ old('location') }}" placeholder="Location">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-map-marker-alt"></span>
                                </div>
                            </div>

                            @error('location')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="input-group mb-3">
                            <input id="license_number" type="text" class="form-control @error('license_number') is-invalid @enderror" name="license_number" value="{{ old('license_number') }}" placeholder="License Number">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-file-alt"></span>
                                </div>
                            </div>

                            @error('license_number')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="input-group mb-3">
                            <input id="pharmacy_contact_no" type="text" class="form-control @error('contact_no') is-invalid @enderror" name="contact_no" value="{{ old('contact_no') }}" placeholder="Contact Number">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-phone"></span>
                                </div>
                            </div>

                            @error('contact_no')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
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
                }

                // Common fields are always visible
                $('#common-fields').show();
            });
        });
    </script>
@endsection

