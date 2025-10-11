<hr>
<h5 class="mb-3">Profile Information</h5>
<div class="form-group row">
    <x-input-label for="contact_no" :value="__('Contact No')" class="col-sm-2 col-form-label"/>
    <div class="col-sm-10">
        <x-text-input id="contact_no" name="contact_no" type="text" class="form-control" placeholder="Contact No" value="{{ optional($user->profile)->contact_no }}"/>
    </div>
</div>
<div class="form-group row">
    <x-input-label for="address" :value="__('Address')" class="col-sm-2 col-form-label"/>
    <div class="col-sm-10">
        <x-text-input id="address" name="address" type="text" class="form-control" placeholder="Address" value="{{ optional($user->profile)->address }}"/>
    </div>
</div>
<div class="form-group row">
    <x-input-label for="city" :value="__('City')" class="col-sm-2 col-form-label"/>
    <div class="col-sm-10">
        <x-text-input id="city" name="city" type="text" class="form-control" placeholder="City" value="{{ optional($user->profile)->city }}"/>
    </div>
</div>
<div class="form-group row">
    <x-input-label for="state" :value="__('State')" class="col-sm-2 col-form-label"/>
    <div class="col-sm-10">
        <x-text-input id="state" name="state" type="text" class="form-control" placeholder="State" value="{{ optional($user->profile)->state }}"/>
    </div>
</div>
<div class="form-group row">
    <x-input-label for="postal_code" :value="__('Postal Code')" class="col-sm-2 col-form-label"/>
    <div class="col-sm-10">
        <x-text-input id="postal_code" name="postal_code" type="text" class="form-control" placeholder="Postal Code" value="{{ optional($user->profile)->postal_code }}"/>
    </div>
</div>
<div class="form-group row">
    <x-input-label for="country" :value="__('Country')" class="col-sm-2 col-form-label"/>
    <div class="col-sm-10">
        <x-text-input id="country" name="country" type="text" class="form-control" placeholder="Country" value="{{ optional($user->profile)->country }}"/>
    </div>
</div>
<div class="form-group row">
    <x-input-label for="date_of_birth" :value="__('Date of Birth')" class="col-sm-2 col-form-label"/>
    <div class="col-sm-10">
        <x-text-input id="date_of_birth" name="date_of_birth" type="date" class="form-control" value="{{ optional($user->profile)->date_of_birth }}"/>
    </div>
</div>
<div class="form-group row">
    <x-input-label for="gender" :value="__('Gender')" class="col-sm-2 col-form-label"/>
    <div class="col-sm-10">
        <select id="gender" name="gender" class="form-control">
            <option value="">Select Gender</option>
            <option value="male" {{ optional($user->profile)->gender == 'male' ? 'selected' : '' }}>Male</option>
            <option value="female" {{ optional($user->profile)->gender == 'female' ? 'selected' : '' }}>Female</option>
            <option value="other" {{ optional($user->profile)->gender == 'other' ? 'selected' : '' }}>Other</option>
        </select>
    </div>
</div>
<div class="form-group row">
    <x-input-label for="blood_group" :value="__('Blood Group')" class="col-sm-2 col-form-label"/>
    <div class="col-sm-10">
        <select id="blood_group" name="blood_group" class="form-control">
            <option value="">Select Blood Group</option>
            @foreach (['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'] as $blood)
                <option value="{{ $blood }}" {{ optional($user->profile)->blood_group == $blood ? 'selected' : '' }}>{{ $blood }}</option>
            @endforeach
        </select>
    </div>
</div>