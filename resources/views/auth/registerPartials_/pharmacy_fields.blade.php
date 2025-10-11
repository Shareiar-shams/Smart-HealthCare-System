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
    <input id="pharmacy_contact_no" type="text" class="form-control @error('phone') is-invalid @enderror" name="contact_no" value="{{ old('contact_no') }}" placeholder="Contact Number">
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