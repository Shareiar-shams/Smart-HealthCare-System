<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
        <img src="{{asset(config('app.logo'))}}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">{{config('app.name')}}</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                @if(Auth::guard()->user()->image)
                    <img src="{{ Auth::guard()->user()->avatar }}" class="img-circle elevation-2" alt="User Image">
                @else
                    <img src="{{asset('assets/img/avatar4.png')}}" class="img-circle elevation-2" alt="User Image">
                @endif
            </div>
            <div class="info">
                <a href="{{route('profile.edit')}}" class="d-block">{{ Auth::guard()->user()->name }}</a>
            </div>
        </div>

        <!-- SidebarSearch Form -->
        <div class="form-inline">
            <div class="input-group" data-widget="sidebar-search">
                <x-text-input class="form-control form-control-navbar" type="search" name="search" placeholder="Search" aria-label="Search" required autofocus autocomplete="search" />
                <div class="input-group-append">
                    <x-ad-nevigation-button class="btn btn-sidebar">
                        <i class="fas fa-search fa-fw"></i>
                    </x-ad-nevigation-button>
                </div>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                @include('layouts.administration.partials_.menus.dashboard')
                
                
                @include('layouts.administration.partials_.menus.system-user.manage')
                @include('layouts.administration.partials_.menus.cache-clear')
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>