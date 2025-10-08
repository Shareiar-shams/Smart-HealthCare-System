<form class="form-horizontal" action="{{ route('profile.update') }}" method="post">
    @csrf
    @method('patch')
    <div class="form-group row">
        <x-input-label for="inputName" :value="__('Name')" class="col-sm-2 col-form-label"/>
        <div class="col-sm-10">
            <x-text-input id="inputName" name="name" type="text" class="form-control" autocomplete="input-name" placeholder="Name" value="{{Auth::guard()->user()->name}}" required/>
        </div>
    </div>
    @if(auth()->user()->role == 'User')
        
        <div class="form-group row">
            <x-input-label for="inputPhone" :value="__('Phone')" class="col-sm-2 col-form-label"/>
            <div class="col-sm-10">
                <x-text-input id="inputPhone" name="phone" type="text" class="form-control" autocomplete="input-phone" placeholder="Phone" value="{{Auth::guard()->user()->profile->contact_no}}" required/>
            </div>
        </div>
        <div class="form-group row">
            <x-input-label for="inputPosition" :value="__('Address')" class="col-sm-2 col-form-label"/>
            <div class="col-sm-10">
                <x-text-input id="inputPosition" name="position" type="text" class="form-control" autocomplete="input-position" placeholder="Position" value="{{Auth::guard()->user()->profile->address}}" required/>
            </div>
        </div>
    @elseif (auth()->user()->role == 'Doctor')
        <div class="form-group row">
            <x-input-label for="registration_no" :value="__('Registration No')" class="col-sm-2 col-form-label"/>
            <div class="col-sm-10">
                <x-text-input id="registration_no" name="registration_no" type="text" class="form-control" autocomplete="input-phone" placeholder="Registration No" value="{{Auth::guard()->user()->doctor->registration_no}}" required/>
            </div>
        </div>
        <div class="form-group row">
            <x-input-label for="specialization" :value="__('Specialization')" class="col-sm-2 col-form-label"/>
            <div class="col-sm-10">
                <x-text-input id="specialization" name="specialization" type="text" class="form-control" autocomplete="input-position" placeholder="Specialization" value="{{Auth::guard()->user()->doctor->specialization}}" required/>
            </div>
        </div>
        <div class="form-group row">
            <x-input-label for="hospital_name" :value="__('Hospital Name')" class="col-sm-2 col-form-label"/>
            <div class="col-sm-10">
                <x-text-input id="hospital_name" name="hospital_name" type="text" class="form-control" autocomplete="input-position" placeholder="Hospital Name" value="{{Auth::guard()->user()->doctor->hospital_name}}" required/>
            </div>
        </div>
        <div class="form-group row">
            <x-input-label for="chamber_address" :value="__('Chamber Address')" class="col-sm-2 col-form-label"/>
            <div class="col-sm-10">
                <x-text-input id="chamber_address" name="chamber_address" type="text" class="form-control" autocomplete="input-position" placeholder="Chamber Address" value="{{Auth::guard()->user()->doctor->chamber_address}}" required/>
            </div>
        </div>

        <div class="form-group row">
            <x-input-label for="available_time" :value="__('Available Times')" class="col-sm-2 col-form-label"/>
            <div class="col-sm-10">
                <x-text-input id="available_time" name="available_time" type="text" class="form-control" autocomplete="input-position" placeholder="Available Times" value="{{Auth::guard()->user()->doctor->available_time}}" required/>
            </div>
        </div>

    @elseif (auth()->user()->role == 'Pharmacy')
        <div class="form-group row">
            <x-input-label for="pharmacy_name" :value="__('Pharmacy Name')" class="col-sm-2 col-form-label"/>
            <div class="col-sm-10">
                <x-text-input id="pharmacy_name" name="pharmacy_name" type="text" class="form-control" autocomplete="input-phone" placeholder="Pharmacy Name" value="{{Auth::guard()->user()->pharmacy->pharmacy_name}}" required/>
            </div>
        </div>
        <div class="form-group row">
            <x-input-label for="owner_name" :value="__('Owner Name')" class="col-sm-2 col-form-label"/>
            <div class="col-sm-10">
                <x-text-input id="owner_name" name="owner_name" type="text" class="form-control" autocomplete="input-position" placeholder="Owner Name" value="{{Auth::guard()->user()->pharmacy->owner_name}}" required/>
            </div>
        </div>
        <div class="form-group row">
            <x-input-label for="license_number" :value="__('License Number')" class="col-sm-2 col-form-label"/>
            <div class="col-sm-10">
                <x-text-input id="license_number" name="license_number" type="text" class="form-control" autocomplete="input-position" placeholder="License Number" value="{{Auth::guard()->user()->pharmacy->license_number}}" required/>
            </div>
        </div>
        <div class="form-group row">
            <x-input-label for="location" :value="__('Location')" class="col-sm-2 col-form-label"/>
            <div class="col-sm-10">
                <x-text-input id="location" name="location" type="text" class="form-control" autocomplete="input-position" placeholder="Location" value="{{Auth::guard()->user()->pharmacy->location}}" required/>
            </div>
        </div>

        <div class="form-group row">
            <x-input-label for="contact_no" :value="__('Contact No')" class="col-sm-2 col-form-label"/>
            <div class="col-sm-10">
                <x-text-input id="contact_no" name="contact_no" type="text" class="form-control" autocomplete="input-position" placeholder="Contact No" value="{{Auth::guard()->user()->pharmacy->contact_no}}" required/>
            </div>
        </div>
    @elseif (auth()->user()->role == 'Patient')
    @else
    @endif
    <div class="form-group row">
        <div class="offset-sm-2 col-sm-10">
            <x-primary-button class="btn btn-primary">{{ __('Save') }}</x-primary-button>
        </div>
    </div>
</form>