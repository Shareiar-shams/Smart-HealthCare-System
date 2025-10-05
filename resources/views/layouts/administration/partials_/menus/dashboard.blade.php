<!-- Dashboard Navigation Link -->
<li class="nav-item">
    <x-ad-nav-link href="{{route('admin.home')}}" class="nav-link {{ Route::currentRouteNamed('admin.home') ? 'active' : '' }}">
        <i class="nav-icon fas fa-tachometer-alt"></i>
        <p>
            Dashboard
        </p>
    </x-ad-nav-link>
</li>