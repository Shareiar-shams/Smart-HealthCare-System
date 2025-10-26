@php
$isActive = 
    Route::is('administration.orders.index') ||
    Route::is('administration.orders.myorder') ||
    Route::is('administration.orders.pharmacy.index')
;
@endphp
<li class="nav-item {{ $isActive ? 'menu-open' : '' }}">
    <a href="#" class="nav-link">
        <i class="nav-icon fas fa-user"></i>
        <p>
            Order
            <i class="fas fa-angle-left right"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        @if(auth()->user()->can('Medicine Order Everything') && auth()->user()->hasRole('Super Admin') )
            <li class="nav-item">
                <a href="{{ route('administration.orders.index') }}" 
                class="nav-link {{ Route::is('administration.orders.index') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon"></i>
                    <p>All Order</p>
                </a>
            </li>
        @endif
        @if(auth()->user()->can('Medicine Order Read') && (auth()->user()->hasRole('Pharmacy') || auth()->user()->hasRole('Super Admin') ) )
            <li class="nav-item">
                <a href="{{ route('administration.orders.pharmacy.index') }}" 
                class="nav-link {{ Route::is('administration.orders.pharmacy.index') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon"></i>
                    <p>All User Order</p>
                </a>
            </li>
        @endif
        @if(auth()->user()->can('Medicine Order Read') && (auth()->user()->hasRole('Patient') || auth()->user()->hasRole('Super Admin') ))
            <li class="nav-item">
                <a href="{{ route('administration.orders.myorder') }}" 
                class="nav-link {{ Route::is('administration.orders.myorder') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon"></i>
                    <p>My Order</p>
                </a>
            </li>
        @endif
    </ul>
</li>