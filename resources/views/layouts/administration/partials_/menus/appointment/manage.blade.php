@php
$isActive = 
    Route::is('administration.appointment.index') 
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
        @if(auth()->user()->can('Appointment Update') && (auth()->user()->hasRole('Patient') || auth()->user()->hasRole('Super Admin') ))
            <li class="nav-item">
                <a href="{{ route('administration.appointment.myAppointments') }}" 
                class="nav-link {{ Route::is('administration.appointment.index') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon"></i>
                    <p>My Appointments</p>
                </a>
            </li>
        @endif
        {{-- <li class="nav-item">
            <a href="{{route('administration.appointment.rolepermission.role.index')}}" class="nav-link {{ Route::is('administration.settings.rolepermission.role.index') ? 'active' : '' }}">
            
                <i class="far fa-circle nav-icon"></i>
                <p>Role</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('administration.settings.user.index') }}" class="nav-link {{ Route::is('administration.settings.user.index') ? 'active' : '' }}">
            
                <i class="far fa-circle nav-icon"></i>
                <p>System User</p>
            </a>
        </li> --}}
    </ul>
</li>