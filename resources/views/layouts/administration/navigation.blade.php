<nav x-data="{ open: false }" class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Primary Navigation Menu -->
    <!-- Left navbar links -->
    <ul class="navbar-nav">
	    <li class="nav-item">
	        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
	    </li>
      	<li class="nav-item d-none d-sm-inline-block">
        	<a href="{{ route('admin.home') }}" class="nav-link">Home</a>
      	</li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
    	<li class="nav-item">
        	<a class="btn btn-sm btn-primary mt-1" title="website" href="" target="_blank">View Website
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

		<!-- language change -->
		<li class="nav-item dropdown">
	        <x-ad-nav-link data-toggle="dropdown" href="#" role="button" aria-expanded="false">
				<i class="fas fa-language"></i>
			</x-ad-nav-link>
	        <div class="dropdown-menu dropdown-menu-sm dropdown-menu-right">
				@foreach (config('localization.languages') as $lang)
					<a class="dropdown-item" href="{{ route('admin.localization', ['lang' => $lang['key']]) }}" data-language="{{ $lang['key'] }}">
						<span class="align-middle">{{ $lang['value'] }}</span>
					</a>
					<div class="dropdown-divider"></div>
				@endforeach
				
				{{-- <div class="dropdown-divider"></div>
				<a href="{{ route('admin.language', ['es']) }}" class="dropdown-item">
					<i class="flag-icon flag-icon-es mr-2"></i> Spanish
				</a> --}}
			</div>
		</li>
		<!-- language change end -->
	    <!-- Messages Dropdown Menu -->
	    <li class="nav-item dropdown">
	    	<x-ad-nav-link data-toggle="dropdown">
                <i class="far fa-comments"></i>
	          <span class="badge badge-danger navbar-badge">{{ isset($notifications) ? $notifications->count() : 0}}</span>
            </x-ad-nav-link>

	        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
	        	
	        	{{-- @forelse($notifications as $notification)
			        <a href="" class="dropdown-item">
			            <!-- Message Start -->
			            <div class="media">
			              	<img @if(isset($notification->mlmuser->user->profile_image))src="{{Storage::disk('local')->url($notification->mlmuser->user->profile_image)}}" @else src="{{asset('assets/img/noimage.jpg')}}" @endif alt="User Avatar" class="img-size-50 mr-3 img-circle">
				            <div class="media-body">
				                <h3 class="dropdown-item-title">
				                  	{{$notification->mlmuser->user->name}}
				                  	<span class="float-right text-sm text-danger"><i class="fas fa-star"></i></span>
				                </h3>
				                <p class="text-sm">{{ getLastMessage($notification) }}</p>
				                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i>{{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $notification->created_at)->format('j M g:i a') }}</p>
				            </div>
			            </div>
			            <!-- Message End -->
			        </a>
		        @empty
		        	<p class="dropdown-item">No Message Available</p>
		        @endforelse --}}
	          	<div class="dropdown-divider"></div>
	          	<a href="" class="dropdown-item dropdown-footer">See All Messages</a>
	        </div>
	    </li>

      	<!-- Notifications Dropdown Menu -->
	    <li class="nav-item dropdown">

	        <a class="nav-link" data-toggle="dropdown" href="#">
	          	<i class="far fa-bell"></i>
	          	<span class="badge badge-warning navbar-badge">15</span>
	        </a>
	        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
	          	<span class="dropdown-item dropdown-header">15 Notifications</span>
	          	<div class="dropdown-divider"></div>
		        <a href="#" class="dropdown-item">
		            <i class="fas fa-envelope mr-2"></i> 4 new Mlm User
		            <span class="float-right text-muted text-sm">3 mins</span>
		        </a>
	          	<div class="dropdown-divider"></div>
		        <a href="#" class="dropdown-item">
		            <i class="fas fa-users mr-2"></i> 8 Transaction done
		            <span class="float-right text-muted text-sm">12 hours</span>
		        </a>

		        <div class="dropdown-divider"></div>
		        <a href="#" class="dropdown-item">
		            <i class="fas fa-users mr-2"></i> 3 new ticket genrate
		            <span class="float-right text-muted text-sm">2 hours</span>
		        </a>
	          
	          	<div class="dropdown-divider"></div>
	          	<a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
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
	            @if(Auth::guard('admin')->user()->image != 'noimage.jpg')
	                <img src="{{ Auth::guard('admin')->user()->avatar }}" class="user-image" alt="User Image">
	            @else
	                <img src="{{asset('assets/img/avatar4.png')}}" class="user-image" alt="User Image">
	            @endif
          	</a>
            <ul class="dropdown-menu">
                <!-- User image -->
                <li class="user-header">
                    @if(Auth::guard('admin')->user()->image != 'noimage.jpg')
                        <img src="{{ Auth::guard('admin')->user()->thumbnail }}" class="img-circle" alt="User Image">
                    @else
                        <img src="{{asset('assets/img/avatar4.png')}}" class="img-circle" alt="User Image">
                    @endif
                    <p>
                      	{{ Auth::guard('admin')->user()->name }} - {{Auth::guard('admin')->user()->position}}
                    </p>
                </li>
                <li class="user-footer w-100 px-3 py-2">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <x-ad-nav-link href="{{route('admin.profile')}}" class="btn btn-default btn-flat">
                                Profile
                            </x-ad-nav-link>
                        </div>
                        <div>
                            <!-- Authentication -->
                            <form method="POST" action="{{ route('admin.logout') }}">
                                @csrf
                                <a href="route('admin.logout')" class="btn btn-default btn-flat"
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
