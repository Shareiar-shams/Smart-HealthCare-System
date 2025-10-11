<form class="form-horizontal" action="{{ route('profile.update') }}" method="post">
    @csrf
    @method('patch')

    @php
        $user = Auth::guard()->user();
        $roleName = $user->role->name ?? optional($user->roles->first())->name; // support spatie roles
        $roleNameLower = $roleName ? strtolower($roleName) : '';

        // Doctor data preparation
        $doctor = $user->doctor ?? null;
        $doctorAvailableDays = [];
        $doctorOpeningTime = null;
        $doctorClosingTime = null;
        $doctorDuration = $doctor->duration ?? 30;
        if ($doctor) {
            $doctorAvailableDays = is_array($doctor->available_days) ? $doctor->available_days : (json_decode($doctor->available_days ?? '[]', true) ?: []);
            $availableTime = is_array($doctor->available_time) ? $doctor->available_time : (json_decode($doctor->available_time ?? '{}', true) ?: []);
            $doctorOpeningTime = $availableTime['opening_time'] ?? null;
            $doctorClosingTime = $availableTime['closing_time'] ?? null;
        }

        // Pharmacy data preparation
        $pharmacy = $user->pharmacy ?? null;
        $pharmacyOpeningTime = null;
        $pharmacyClosingTime = null;
        if ($pharmacy) {
            $openingHours = is_array($pharmacy->opening_hours) ? $pharmacy->opening_hours : (json_decode($pharmacy->opening_hours ?? '{}', true) ?: []);
            $pharmacyOpeningTime = $openingHours['opening_time'] ?? null;
            $pharmacyClosingTime = $openingHours['closing_time'] ?? null;
        }
    @endphp

    <div class="form-group row">
        <x-input-label for="inputName" :value="__('Name')" class="col-sm-2 col-form-label"/>
        <div class="col-sm-10">
            <x-text-input id="inputName" name="name" type="text" class="form-control" autocomplete="input-name" placeholder="Name" value="{{ $user->name }}" required/>
        </div>
    </div>

    {{-- Common Profile Fields for all roles --}}
    @if ($roleNameLower === 'patient')
        
        @include('admin.profile.partials.roleBasedFields.general_profile_fields')
    {{-- Doctor Fields --}}
    @elseif($roleNameLower === 'doctor')
        @include('admin.profile.partials.roleBasedFields.doctor_fields')
    @endif

    {{-- Pharmacy Fields --}}
    @if($roleNameLower === 'pharmacy')
        @include('admin.profile.partials.roleBasedFields.pharmacy_fields')
    @endif

    <div class="form-group row">
        <div class="offset-sm-2 col-sm-10">
            <x-primary-button class="btn btn-primary">{{ __('Save') }}</x-primary-button>
        </div>
    </div>
</form>
