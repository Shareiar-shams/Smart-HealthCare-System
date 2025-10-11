@php
$isActive = 
    Route::is('administration.appointment.index') ||
    Route::is('administration.appointment.myAppointments') ||
    Route::is('administration.appointment.create') ||
    Route::is('administration.appointment.myPatientsAppointments')
;
@endphp
<li class="nav-item {{ $isActive ? 'menu-open' : '' }}">
    <a href="#" class="nav-link">
        <i class="nav-icon fas fa-user"></i>
        <p>
            Appointments
            <i class="fas fa-angle-left right"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        @if(auth()->user()->can('Appointment Read') && auth()->user()->hasRole('Super Admin') )
            <li class="nav-item">
                <a href="{{ route('administration.appointment.index') }}" 
                class="nav-link {{ Route::is('administration.appointment.index') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon"></i>
                    <p>All Appointments</p>
                </a>
            </li>
        @endif
        @if(auth()->user()->can('Appointment Read') && (auth()->user()->hasRole('Patient') || auth()->user()->hasRole('Super Admin') ))
            <li class="nav-item">
                <a href="{{ route('administration.appointment.myAppointments') }}" 
                class="nav-link {{ Route::is('administration.appointment.myAppointments') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon"></i>
                    <p>My Appointments</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('administration.appointment.create') }}" 
                class="nav-link {{ Route::is('administration.appointment.create') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Appointment Create</p>
                </a>
            </li>
        @endif

        @if(auth()->user()->can('Appointment Read') && (auth()->user()->hasRole('Doctor') || auth()->user()->hasRole('Super Admin') ))
            <li class="nav-item">
                <a href="{{ route('administration.appointment.myPatientsAppointments') }}" 
                class="nav-link {{ Route::is('administration.appointment.myPatientsAppointments') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon"></i>
                    <p>All Patients Appointments</p>
                </a>
            </li>
        @endif
    </ul>
</li>