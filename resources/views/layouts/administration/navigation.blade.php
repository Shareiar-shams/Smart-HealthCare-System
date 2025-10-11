<nav x-data="{ open: false }" class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Primary Navigation Menu -->
    <!-- Left navbar links -->
    <ul class="navbar-nav">
	    <li class="nav-item">
	        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
	    </li>
      	<li class="nav-item d-none d-sm-inline-block">
        	<a href="{{ route('dashboard') }}" class="nav-link">Home</a>
      	</li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
    	<li class="nav-item">
        	<a class="btn btn-sm btn-primary mt-1" title="website" href="{{route('index')}}" target="_blank">View Website
            </a>
      	</li>
      	
      	<!-- Navbar Search -->
      	<li class="nav-item">
      		<x-ad-nav-link data-widget="navbar-search"  role="button">
                <i class="fas fa-search"></i>
            </x-ad-nav-link>

	        <div class="navbar-search-block">
		        <form class="form-inline">
		            <div class="input-group input-group-sm">
		            	<x-text-input class="form-control form-control-navbar" type="search" name="search" placeholder="Search" aria-label="Search" required autofocus autocomplete="search" />

			            <div class="input-group-append">
			                <x-ad-nevigation-button>
			                  	<i class="fas fa-search"></i>
			                </x-ad-nevigation-button>
			                <x-ad-nevigation-button data-widget="navbar-search">
			                  	<i class="fas fa-times"></i>
			                </x-ad-nevigation-button>
			            </div>
		            </div>
		        </form>
	        </div>
      	</li>

	    
	    <li class="nav-item">
	    	<x-ad-nav-link data-widget="fullscreen" role="button">
                <i class="fas fa-expand-arrows-alt"></i>
            </x-ad-nav-link>
	    </li>
	    <li class="nav-item">
	    	<x-ad-nav-link data-widget="control-sidebar" data-controlsidebar-slide="true" role="button">
                <i class="fas fa-th-large"></i>
            </x-ad-nav-link>
	    </li>

	    <li class="pt-2 nav-item dropdown user user-menu">
          	<a href="#" class="dropdown-toggle" data-toggle="dropdown">
	            @if(Auth::guard()->user()->image)
	                <img src="{{ Auth::guard()->user()->avatar }}" class="user-image" alt="User Image">
	            @else
	                <img src="{{asset('assets/img/avatar4.png')}}" class="user-image" alt="User Image">
	            @endif
          	</a>
            <ul class="dropdown-menu">
                <!-- User image -->
                <li class="user-header">
                    @if(Auth::guard()->user()->image)
                        <img src="{{ Auth::guard()->user()->thumbnail }}" class="img-circle" alt="User Image">
                    @else
                        <img src="{{asset('assets/img/avatar4.png')}}" class="img-circle" alt="User Image">
                    @endif
                    <p>
                      	{{ Auth::guard()->user()->name }} - {{Auth::guard()->user()->position}}
                    </p>
                </li>
                <li class="user-footer w-100 px-3 py-2">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <x-ad-nav-link href="{{route('profile.edit')}}" class="btn btn-default btn-flat">
                                Profile
                            </x-ad-nav-link>
                        </div>
                        <div>
                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <a href="route('logout')" class="btn btn-default btn-flat"
                                    onclick="event.preventDefault();
                                            this.closest('form').submit();">
                                    {{ __('Log Out') }}
                                </a>
                            </form>
                        </div>
                    </div>
                </li>
            </ul>
        </li>
    </ul>

</nav>
