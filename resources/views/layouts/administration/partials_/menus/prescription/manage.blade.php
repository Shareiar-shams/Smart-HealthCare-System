@php
$isActive = 
    Route::is('administration.prescriptions.index') 
;
@endphp
<li class="nav-item {{ $isActive ? 'menu-open' : '' }}">
    <a href="#" class="nav-link">
        <i class="nav-icon fas fa-user"></i>
        <p>
            Prescription
            <i class="fas fa-angle-left right"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        @if(auth()->user()->can('Prescription Read') && auth()->user()->hasRole('Super Admin') )
            <li class="nav-item">
                <a href="{{ route('administration.prescriptions.index') }}" 
                class="nav-link {{ Route::is('administration.prescriptions.index') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon"></i>
                    <p>All Prescriptions</p>
                </a>
            </li>
        @endif
        @if(auth()->user()->can('Appointment Read') && (auth()->user()->hasRole('Patient') || auth()->user()->hasRole('Super Admin') ))
            
        @endif

        @if(auth()->user()->can('Appointment Read') && (auth()->user()->hasRole('Doctor') || auth()->user()->hasRole('Super Admin') ))
            
        @endif
    </ul>
</li>