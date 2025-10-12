<!-- Dashboard Navigation Link -->
<li class="nav-item">
    <x-ad-nav-link href="{{route('dashboard')}}" class="nav-link {{ Route::is('dashboard') ? 'active' : '' }}">
        <i class="nav-icon fas fa-tachometer-alt"></i>
        <p>
            Dashboard
        </p>
    </x-ad-nav-link>
</li>