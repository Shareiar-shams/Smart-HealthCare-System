<hr>
<h5 class="mb-3">Professional Information</h5>
<div class="form-group row">
    <x-input-label for="specialty" :value="__('Specialty')" class="col-sm-2 col-form-label"/>
    <div class="col-sm-10">
        <x-text-input id="specialty" name="specialty" type="text" class="form-control" placeholder="Specialty" value="{{ $doctor->specialty ?? '' }}" required/>
    </div>
</div>
<div class="form-group row">
    <x-input-label for="qualification" :value="__('Qualification')" class="col-sm-2 col-form-label"/>
    <div class="col-sm-10">
        <x-text-input id="qualification" name="qualification" type="text" class="form-control" placeholder="Qualification" value="{{ $doctor->qualification ?? '' }}" required/>
    </div>
</div>
<div class="form-group row">
    <x-input-label for="experience_years" :value="__('Experience (Years)')" class="col-sm-2 col-form-label"/>
    <div class="col-sm-10">
        <x-text-input id="experience_years" name="experience_years" type="number" class="form-control" placeholder="Years of Experience" value="{{ $doctor->experience_years ?? '' }}" required/>
    </div>
</div>
<div class="form-group row">
    <x-input-label for="license_number" :value="__('License Number')" class="col-sm-2 col-form-label"/>
    <div class="col-sm-10">
        <x-text-input id="license_number" name="license_number" type="text" class="form-control" placeholder="License Number" value="{{ $doctor->license_number ?? '' }}" required/>
    </div>
</div>
<div class="form-group row">
    <x-input-label for="chamber_address" :value="__('Chamber Address')" class="col-sm-2 col-form-label"/>
    <div class="col-sm-10">
        <x-text-input id="chamber_address" name="chamber_address" type="text" class="form-control" placeholder="Chamber Address" value="{{ $doctor->chamber_address ?? '' }}"/>
    </div>
</div>
<div class="form-group row">
    <x-input-label for="consultation_fee" :value="__('Consultation Fee')" class="col-sm-2 col-form-label"/>
    <div class="col-sm-10">
        <x-text-input id="consultation_fee" name="consultation_fee" type="number" step="0.01" class="form-control" placeholder="Consultation Fee" value="{{ $doctor->consultation_fee ?? '' }}" required/>
    </div>
</div>
<div class="form-group row">
    <x-input-label for="bio" :value="__('Professional Bio')" class="col-sm-2 col-form-label"/>
    <div class="col-sm-10">
        <textarea id="bio" name="bio" class="form-control" rows="4" placeholder="Professional Bio">{{ $doctor->bio ?? '' }}</textarea>
    </div>
</div>
<div class="form-group row">
    <x-input-label :value="__('Available Days')" class="col-sm-2 col-form-label"/>
    <div class="col-sm-10">
        <div class="row">
            @foreach(['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'] as $day)
                <div class="col-md-4">
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="available_days_{{ strtolower($day) }}" name="available_days[]" value="{{ $day }}" {{ in_array($day, $doctorAvailableDays) ? 'checked' : '' }}>
                        <label class="form-check-label" for="available_days_{{ strtolower($day) }}">{{ $day }}</label>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
<div class="form-group row">
    <x-input-label :value="__('Opening Hours')" class="col-sm-2 col-form-label"/>
    <div class="col-sm-5">
        <div class="input-group">
            <x-text-input id="opening_time" name="opening_time" type="time" class="form-control" value="{{ $doctorOpeningTime }}"/>
        </div>
    </div>
    <div class="col-sm-5">
        <div class="input-group">
            <x-text-input id="closing_time" name="closing_time" type="time" class="form-control" value="{{ $doctorClosingTime }}"/>
        </div>
    </div>
</div>
<div class="form-group row">
    <x-input-label for="time_slot_duration" :value="__('Time Slot Duration (minutes)')" class="col-sm-2 col-form-label"/>
    <div class="col-sm-10">
        <x-text-input id="time_slot_duration" name="time_slot_duration" type="number" min="15" max="120" step="15" class="form-control" value="{{ $doctorDuration }}"/>
    </div>
</div>