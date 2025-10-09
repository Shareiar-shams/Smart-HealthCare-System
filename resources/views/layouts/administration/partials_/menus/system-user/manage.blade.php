@php
$isActive = 
    Route::is('administration.settings.rolepermission.permission.index') || 
    Route::is('administration.settings.rolepermission.role.index') || 
    Route::is('administration.settings.user.index');
@endphp
<li class="nav-item {{ $isActive ? 'menu-open' : '' }}">
    <a href="#" class="nav-link">
        <i class="nav-icon fas fa-user"></i>
        <p>
            System User
            <i class="fas fa-angle-left right"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{ route('administration.settings.rolepermission.permission.index') }}" class="nav-link {{ Route::is('administration.settings.rolepermission.permission.index') ? 'active' : '' }}">
            
                <i class="far fa-circle nav-icon"></i>
                <p>Permission</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{route('administration.settings.rolepermission.role.index')}}" class="nav-link {{ Route::is('administration.settings.rolepermission.role.index') ? 'active' : '' }}">
            
                <i class="far fa-circle nav-icon"></i>
                <p>Role</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('administration.settings.user.index') }}" class="nav-link {{ Route::is('administration.settings.user.index') ? 'active' : '' }}">
            
                <i class="far fa-circle nav-icon"></i>
                <p>System User</p>
            </a>
        </li>
    </ul>
</li>