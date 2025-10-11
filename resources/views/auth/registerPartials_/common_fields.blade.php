<div class="input-group mb-3">
    <input id="contact_no" type="text" class="form-control @error('contact_no') is-invalid @enderror" name="contact_no" value="{{ old('contact_no') }}" required placeholder="Phone Number">
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
    <input id="country" type="text" class="form-control @error('country') is-invalid @enderror" name="country" value="{{ old('country') }}" required placeholder="Country">
    <div class="input-group-append">
        <div class="input-group-text">
            <span class="fas fa-mail-bulk"></span>
        </div>
    </div>
    @error('country')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
</div>

<div class="input-group mb-3">
    <input id="date_of_birth" type="date" class="form-control @error('date_of_birth') is-invalid @enderror" name="date_of_birth" value="{{ old('date_of_birth') }}" required placeholder="date_of_birth">
    <div class="input-group-append">
        <div class="input-group-text">
            <span class="fa fa-calendar"></span>
        </div>
    </div>
    @error('date_of_birth')
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