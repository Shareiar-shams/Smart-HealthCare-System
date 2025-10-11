<hr>
<h5 class="mb-3">Pharmacy Information</h5>
<div class="form-group row">
    <x-input-label for="pharmacy_name" :value="__('Pharmacy Name')" class="col-sm-2 col-form-label"/>
    <div class="col-sm-10">
        <x-text-input id="pharmacy_name" name="pharmacy_name" type="text" class="form-control" placeholder="Pharmacy Name" value="{{ $pharmacy->pharmacy_name ?? '' }}" required/>
    </div>
</div>
<div class="form-group row">
    <x-input-label for="owner_name" :value="__('Owner Name')" class="col-sm-2 col-form-label"/>
    <div class="col-sm-10">
        <x-text-input id="owner_name" name="owner_name" type="text" class="form-control" placeholder="Owner Name" value="{{ $pharmacy->owner_name ?? '' }}"/>
    </div>
</div>
<div class="form-group row">
    <x-input-label for="license_number" :value="__('License Number')" class="col-sm-2 col-form-label"/>
    <div class="col-sm-10">
        <x-text-input id="license_number" name="license_number" type="text" class="form-control" placeholder="License Number" value="{{ $pharmacy->license_number ?? '' }}" required/>
    </div>
</div>
<div class="form-group row">
    <x-input-label for="pharmacy_contact_no" :value="__('Contact No')" class="col-sm-2 col-form-label"/>
    <div class="col-sm-10">
        <x-text-input id="pharmacy_contact_no" name="pharmacy_contact_no" type="text" class="form-control" placeholder="Contact No" value="{{ $pharmacy->contact_no ?? '' }}"/>
    </div>
</div>
<div class="form-group row">
    <x-input-label for="address" :value="__('Address')" class="col-sm-2 col-form-label"/>
    <div class="col-sm-10">
        <x-text-input id="pharmacy_address" name="pharmacy_address" type="text" class="form-control" placeholder="Address" value="{{ $pharmacy->address ?? '' }}"/>
    </div>
</div>
<div class="form-group row">
    <x-input-label for="city" :value="__('City')" class="col-sm-2 col-form-label"/>
    <div class="col-sm-10">
        <x-text-input id="pharmacy_city" name="pharmacy_city" type="text" class="form-control" placeholder="City" value="{{ $pharmacy->city ?? '' }}"/>
    </div>
</div>
<div class="form-group row">
    <x-input-label for="state" :value="__('State')" class="col-sm-2 col-form-label"/>
    <div class="col-sm-10">
        <x-text-input id="pharmacy_state" name="pharmacy_state" type="text" class="form-control" placeholder="State" value="{{ $pharmacy->state ?? '' }}"/>
    </div>
</div>
<div class="form-group row">
    <x-input-label for="postal_code" :value="__('Postal Code')" class="col-sm-2 col-form-label"/>
    <div class="col-sm-10">
        <x-text-input id="pharmacy_postal_code" name="pharmacy_postal_code" type="text" class="form-control" placeholder="Postal Code" value="{{ $pharmacy->postal_code ?? '' }}"/>
    </div>
</div>
<div class="form-group row">
    <x-input-label :value="__('Opening Hours')" class="col-sm-2 col-form-label"/>
    <div class="col-sm-5">
        <div class="input-group">
            <x-text-input id="pharmacy_opening_time" name="opening_time" type="time" class="form-control" value="{{ $pharmacyOpeningTime }}"/>
        </div>
    </div>
    <div class="col-sm-5">
        <div class="input-group">
            <x-text-input id="pharmacy_closing_time" name="closing_time" type="time" class="form-control" value="{{ $pharmacyClosingTime }}"/>
        </div>
    </div>
</div>
<div class="form-group row">
    <x-input-label for="delivery_available" :value="__('Delivery Service')" class="col-sm-2 col-form-label"/>
    <div class="col-sm-10">
        <div class="form-check">
            <input type="checkbox" class="form-check-input" id="delivery_available" name="delivery_available" {{ ($pharmacy->delivery_available ?? false) ? 'checked' : '' }}>
            <label class="form-check-label" for="delivery_available">Delivery Available</label>
        </div>
    </div>
</div>
<div class="form-group row">
    <x-input-label for="emergency_service" :value="__('Emergency Service')" class="col-sm-2 col-form-label"/>
    <div class="col-sm-10">
        <div class="form-check">
            <input type="checkbox" class="form-check-input" id="emergency_service" name="emergency_service" {{ ($pharmacy->emergency_service ?? false) ? 'checked' : '' }}>
            <label class="form-check-label" for="emergency_service">Emergency Service Available</label>
        </div>
    </div>
</div>
<div class="form-group row">
    <x-input-label for="description" :value="__('Description')" class="col-sm-2 col-form-label"/>
    <div class="col-sm-10">
        <textarea id="description" name="description" class="form-control" rows="4" placeholder="Pharmacy Description">{{ $pharmacy->description ?? '' }}</textarea>
    </div>
</div>