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

<div class="form-group mb-3">
    <label>Available Days</label>
    <div class="row">
        @foreach(['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'] as $day)
            <div class="col-md-6">
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="available_days_{{ strtolower($day) }}" 
                        name="available_days[]" value="{{ $day }}"
                        {{ (is_array(old('available_days')) && in_array($day, old('available_days'))) ? 'checked' : '' }}>
                    <label class="form-check-label" for="available_days_{{ strtolower($day) }}">{{ $day }}</label>
                </div>
            </div>
        @endforeach
    </div>
    @error('available_days')
        <span class="invalid-feedback d-block" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
</div>

<div class="form-group mb-3">
    <label>Opening Hours</label>
    <div class="row">
        <div class="col-md-6">
            <div class="input-group mb-3">
                <input type="time" class="form-control @error('opening_time') is-invalid @enderror" 
                    id="opening_time" name="opening_time" value="{{ old('opening_time') }}"
                    placeholder="Opening Time">
                <div class="input-group-append">
                    <div class="input-group-text">
                        <span class="fas fa-clock"></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="input-group mb-3">
                <input type="time" class="form-control @error('closing_time') is-invalid @enderror" 
                    id="closing_time" name="closing_time" value="{{ old('closing_time') }}"
                    placeholder="Closing Time">
                <div class="input-group-append">
                    <div class="input-group-text">
                        <span class="fas fa-clock"></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @error('opening_time')
        <span class="invalid-feedback d-block" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
    @error('closing_time')
        <span class="invalid-feedback d-block" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
</div>

<div class="form-group mb-3">
    <label>Available Time Slots (Duration in minutes)</label>
    <div class="input-group mb-3">
        <input type="number" class="form-control @error('time_slot_duration') is-invalid @enderror" 
            id="time_slot_duration" name="time_slot_duration" value="{{ old('time_slot_duration', 30) }}"
            min="15" max="120" step="15" placeholder="Time Slot Duration">
        <div class="input-group-append">
            <div class="input-group-text">
                <span class="fas fa-hourglass"></span>
            </div>
        </div>
    </div>
    @error('time_slot_duration')
        <span class="invalid-feedback d-block" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
</div>