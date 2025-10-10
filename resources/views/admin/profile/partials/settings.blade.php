<form class="form-horizontal" action="{{ route('profile.update') }}" method="post">
    @csrf
    @method('patch')
    <div class="form-group row">
        <x-input-label for="inputName" :value="__('Name')" class="col-sm-2 col-form-label"/>
        <div class="col-sm-10">
            <x-text-input id="inputName" name="name" type="text" class="form-control" autocomplete="input-name" placeholder="Name" value="{{Auth::guard()->user()->name}}" required/>
        </div>
    </div>
    {{-- Common Profile Fields --}}
    @if(auth()->user()->role == 'patient')
        <div class="form-group row">
            <x-input-label for="phone" :value="__('Phone')" class="col-sm-2 col-form-label"/>
            <div class="col-sm-10">
                <x-text-input id="phone" name="phone" type="text" class="form-control" placeholder="Phone" value="{{Auth::guard()->user()->profile->contact_no}}" required/>
            </div>
        </div>
        <div class="form-group row">
            <x-input-label for="address" :value="__('Address')" class="col-sm-2 col-form-label"/>
            <div class="col-sm-10">
                <x-text-input id="address" name="address" type="text" class="form-control" placeholder="Address" value="{{Auth::guard()->user()->profile->address}}" required/>
            </div>
        </div>
        <div class="form-group row">
            <x-input-label for="city" :value="__('City')" class="col-sm-2 col-form-label"/>
            <div class="col-sm-10">
                <x-text-input id="city" name="city" type="text" class="form-control" placeholder="City" value="{{Auth::guard()->user()->profile->city}}" required/>
            </div>
        </div>
        <div class="form-group row">
            <x-input-label for="state" :value="__('State')" class="col-sm-2 col-form-label"/>
            <div class="col-sm-10">
                <x-text-input id="state" name="state" type="text" class="form-control" placeholder="State" value="{{Auth::guard()->user()->profile->state}}" required/>
            </div>
        </div>
        <div class="form-group row">
            <x-input-label for="postal_code" :value="__('Postal Code')" class="col-sm-2 col-form-label"/>
            <div class="col-sm-10">
                <x-text-input id="postal_code" name="postal_code" type="text" class="form-control" placeholder="Postal Code" value="{{Auth::guard()->user()->profile->postal_code}}" required/>
            </div>
        </div>
        <div class="form-group row">
            <x-input-label for="gender" :value="__('Gender')" class="col-sm-2 col-form-label"/>
            <div class="col-sm-10">
                <select id="gender" name="gender" class="form-control" required>
                    <option value="">Select Gender</option>
                    <option value="male" {{ Auth::guard()->user()->profile->gender == 'male' ? 'selected' : '' }}>Male</option>
                    <option value="female" {{ Auth::guard()->user()->profile->gender == 'female' ? 'selected' : '' }}>Female</option>
                    <option value="other" {{ Auth::guard()->user()->profile->gender == 'other' ? 'selected' : '' }}>Other</option>
                </select>
            </div>
        </div>
        <div class="form-group row">
        <x-input-label for="blood_group" :value="__('Blood Group')" class="col-sm-2 col-form-label"/>
        <div class="col-sm-10">
            <select id="blood_group" name="blood_group" class="form-control" required>
                <option value="">Select Blood Group</option>
                @foreach (['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'] as $blood)
                    <option value="{{ $blood }}" {{ Auth::guard()->user()->profile->blood_group == $blood ? 'selected' : '' }}>{{ $blood }}</option>
                @endforeach
            </select>
        </div>
    </div>
    @elseif(auth()->user()->role == 'doctor')
        <hr>
        <h5 class="mb-3">Professional Information</h5>
        <div class="form-group row">
            <x-input-label for="specialty" :value="__('Specialty')" class="col-sm-2 col-form-label"/>
            <div class="col-sm-10">
                <x-text-input id="specialty" name="specialty" type="text" class="form-control" placeholder="Specialty" value="{{Auth::guard()->user()->doctor->specialty}}" required/>
            </div>
        </div>
        <div class="form-group row">
            <x-input-label for="qualification" :value="__('Qualification')" class="col-sm-2 col-form-label"/>
            <div class="col-sm-10">
                <x-text-input id="qualification" name="qualification" type="text" class="form-control" placeholder="Qualification" value="{{Auth::guard()->user()->doctor->qualification}}" required/>
            </div>
        </div>
        <div class="form-group row">
            <x-input-label for="experience_years" :value="__('Experience (Years)')" class="col-sm-2 col-form-label"/>
            <div class="col-sm-10">
                <x-text-input id="experience_years" name="experience_years" type="number" class="form-control" placeholder="Years of Experience" value="{{Auth::guard()->user()->doctor->experience_years}}" required/>
            </div>
        </div>
        <div class="form-group row">
            <x-input-label for="license_number" :value="__('License Number')" class="col-sm-2 col-form-label"/>
            <div class="col-sm-10">
                <x-text-input id="license_number" name="license_number" type="text" class="form-control" placeholder="License Number" value="{{Auth::guard()->user()->doctor->license_number}}" required/>
            </div>
        </div>
        <div class="form-group row">
            <x-input-label for="consultation_fee" :value="__('Consultation Fee')" class="col-sm-2 col-form-label"/>
            <div class="col-sm-10">
                <x-text-input id="consultation_fee" name="consultation_fee" type="number" step="0.01" class="form-control" placeholder="Consultation Fee" value="{{Auth::guard()->user()->doctor->consultation_fee}}" required/>
            </div>
        </div>
        <div class="form-group row">
            <x-input-label for="bio" :value="__('Professional Bio')" class="col-sm-2 col-form-label"/>
            <div class="col-sm-10">
                <textarea id="bio" name="bio" class="form-control" rows="4" placeholder="Professional Bio">{{Auth::guard()->user()->doctor->bio}}</textarea>
            </div>
        </div>

    @elseif (auth()->user()->role == 'pharmacy')
        <hr>
        <h5 class="mb-3">Pharmacy Information</h5>
        <div class="form-group row">
            <x-input-label for="pharmacy_name" :value="__('Pharmacy Name')" class="col-sm-2 col-form-label"/>
            <div class="col-sm-10">
                <x-text-input id="pharmacy_name" name="pharmacy_name" type="text" class="form-control" placeholder="Pharmacy Name" value="{{Auth::guard()->user()->pharmacy->pharmacy_name}}" required/>
            </div>
        </div>
        <div class="form-group row">
            <x-input-label for="license_number" :value="__('License Number')" class="col-sm-2 col-form-label"/>
            <div class="col-sm-10">
                <x-text-input id="license_number" name="license_number" type="text" class="form-control" placeholder="License Number" value="{{Auth::guard()->user()->pharmacy->license_number}}" required/>
            </div>
        </div>
        <div class="form-group row">
            <x-input-label for="delivery_available" :value="__('Delivery Service')" class="col-sm-2 col-form-label"/>
            <div class="col-sm-10">
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="delivery_available" name="delivery_available" {{ Auth::guard()->user()->pharmacy->delivery_available ? 'checked' : '' }}>
                    <label class="form-check-label" for="delivery_available">Delivery Available</label>
                </div>
            </div>
        </div>
        <div class="form-group row">
            <x-input-label for="emergency_service" :value="__('Emergency Service')" class="col-sm-2 col-form-label"/>
            <div class="col-sm-10">
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="emergency_service" name="emergency_service" {{ Auth::guard()->user()->pharmacy->emergency_service ? 'checked' : '' }}>
                    <label class="form-check-label" for="emergency_service">Emergency Service Available</label>
                </div>
            </div>
        </div>
        <div class="form-group row">
            <x-input-label for="description" :value="__('Description')" class="col-sm-2 col-form-label"/>
            <div class="col-sm-10">
                <textarea id="description" name="description" class="form-control" rows="4" placeholder="Pharmacy Description">{{Auth::guard()->user()->pharmacy->description}}</textarea>
            </div>
        </div>
    @endif
    <div class="form-group row">
        <div class="offset-sm-2 col-sm-10">
            <x-primary-button class="btn btn-primary">{{ __('Save') }}</x-primary-button>
        </div>
    </div>
</form>