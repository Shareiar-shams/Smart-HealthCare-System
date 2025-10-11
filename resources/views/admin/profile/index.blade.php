@extends('layouts.administration.app')
@section('admin_title_content')
    {{config('app.name')}} || Dashboard Profile
@endsection
@section('admin_content_header')
    <div class="col-sm-6">
        <h1 class="m-0">Profile</h1>
    </div><!-- /.col -->
    <!-- breadcrumb -->
    <x-ad-breadcrumb :items="[
        ['label' => 'Dashboard', 'url' => route('dashboard')],
        ['label' => 'Profile', 'url' => route('profile.edit')],
    ]" />
@endsection

@section('admin_vendor_css')
@endsection

@section('admin_page_css')
    <style>
        .profile-img-wrapper {
            position: relative;
            display: inline-block;
            cursor: pointer;
        }

        .profile-img-wrapper::before {
            content: "";
            position: absolute;
            inset: 0;                  /* top:0; right:0; bottom:0; left:0; */
            border-radius: 50%;        /* assume circular avatar — adjust if needed */
            background: rgba(0,0,0,0.20);
            opacity: 0;
            transition: opacity .15s ease;
            pointer-events: none;
        }

        /* show overlay on hover/focus-within for keyboard users */
        .profile-img-wrapper:hover::before,
        .profile-img-wrapper:focus-within::before {
            opacity: 1;
        }

        /* camera icon — bottom-right overlay */
        .profile-img-wrapper .camera-icon {
            position: absolute;
            bottom: 6px; 
            right: 6px;
            z-index: 3;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 6px;
            border-radius: 50%;
            background: #fff;
            box-shadow: 0 2px 6px rgba(0,0,0,0.22);
            pointer-events: auto;
        }

        /* icon size */
        .profile-img-wrapper .camera-icon i {
            font-size: 14px;
            line-height: 1;
            color: #333;
        }
    </style>
@endsection

@section('main_content')
    <!-- Display Validation Error -->
	@include('admin.validationError.error')
    <!-- container-fluid -->
	<div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header p-2">
                        <ul class="nav nav-pills">
                            <li class="nav-item"><a class="nav-link active" href="#activity" data-toggle="tab">Settings</a></li>
                            <li class="nav-item"><a class="nav-link" href="#settings" data-toggle="tab">Change Password</a></li>
                            <li class="nav-item"><a class="nav-link" href="#preferences" data-toggle="tab">Preferences</a></li>
                            <li class="nav-item"><a class="nav-link" href="#delete_account" data-toggle="tab">Delete Account</a></li>
                        </ul>
                    </div><!-- /.card-header -->
                    <div class="card-body">
                        <div class="tab-content">
                            <div class="active tab-pane" id="activity">
                                @include('admin.profile.partials.settings')
                            </div>
                            <div class="tab-pane" id="settings">
                                @include('admin.profile.partials.change_password')
                            </div>
                            <div class="tab-pane" id="preferences">
                                @include('admin.profile.partials.preferences')
                            </div>
                            <div class="tab-pane" id="delete_account">
                                @include('admin.profile.partials.delete_account')
                            </div>
                        </div>
                    </div><!-- /.card-body -->
                </div>
                <!-- /.card -->

                <!-- Activity Log Section -->
                <div class="card mt-4">
                    <div class="card-header">
                        <h3 class="card-title">Recent Activity</h3>
                    </div>
                    <div class="card-body p-0">
                        <ul class="list-group list-group-flush">
                            @forelse($activities as $activity)
                                <li class="list-group-item">
                                    <p> 
                                        {{ $activity->created_at->diffForHumans() }} -
                                        {{ $activity->description }} -
                                        URL: {{ $activity->properties['url'] ?? '' }}
                                    </p>
                                </li>
                            @empty
                                <li class="list-group-item">
                                    <p>No recent activity found.</p>
                                </li>
                            @endforelse
                        </ul>
                    </div>
                    <div class="card-footer">
                        <a href="{{ route('activities.index') }}" class="btn btn-primary float-right">View All Activities</a>
                    </div>
                </div>
                <!-- /.Activity Log Section -->
            </div>
          	<!-- /.col -->
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
@endsection

@section('admin_page_js')
	<script>
		var loadFile = function(event) {
			var image = document.getElementById('output');
			image.src = URL.createObjectURL(event.target.files[0]);
		};
	</script>
@endsection