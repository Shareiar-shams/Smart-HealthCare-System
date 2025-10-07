<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Admin Login') }}</title>

        <!-- Google Font: Source Sans Pro -->
  		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  		<link rel="stylesheet" type="text/css" href="{{asset('admin/assets/plugins/fontawesome-free/css/all.min.css')}}">
  		<link rel="stylesheet" type="text/css" href="{{asset('admin/assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">
  		<link rel="stylesheet" type="text/css" href="{{asset('admin/assets/dist/css/adminlte.min.css')}}">
        <!-- Scripts -->
        {{-- <script src="{{asset('js/login.js')}}" type="text/javascript" charset="utf-8" async defer></script>  --}}
        {{-- @vite(['resources/js/login.js']) --}}
    </head>
    <body class="hold-transition login-page">
		<div class="login-box">
		  	<!-- /.login-logo -->
		  	<div class="card card-outline card-primary">
			    <div class="card-header text-center">
			      	<a href="javascript:void(0)" class="h1"><b>AH</b>Knoxo</a>
			    </div>
			    <div class="card-body">
			      	<p class="login-box-msg">Sign in to start your session</p>

			      	<form action="{{route('admin.login.post')}}" method="post">
			      		@csrf
				        <div class="input-group mb-3">
				            <x-text-input id="email" class="form-control" type="email" name="email" :value="old('email')" placeholder="Email" required autofocus autocomplete="username" />
				          	<div class="input-group-append">
				            	<div class="input-group-text">
				              		<span class="fas fa-envelope"></span>
				            	</div>
				         	</div>
				            <x-input-error :messages="$errors->get('email')" class="mt-2" />
				        </div>
				        <div class="input-group mb-3">
				        	<x-text-input id="password" class="form-control"
                            type="password"
                            name="password"
                            placeholder="Password"
                            required autocomplete="current-password" />
                            <div class="input-group-append">
					            <div class="input-group-text">
					              	<span class="fas fa-lock"></span>
					            </div>
					        </div>
				            <x-input-error :messages="$errors->get('password')" class="mt-2" />
				        </div>
				        <div class="row">
					        <div class="col-8">
					            <div class="icheck-primary">
					              	<input type="checkbox" id="remember" name="remember">
					              	<label for="remember">
					                	{{ __('Remember me') }}
					              	</label>
					            </div>
					        </div>
				          	<!-- /.col -->
				          	<div class="col-4">
				            	<button type="submit" class="btn btn-primary btn-block">{{ __('Log in') }}</button>
				          	</div>
				          	<!-- /.col -->
				        </div>
			    	</form>

			    </div>
		    	<!-- /.card-body -->
		  	</div>
		  	<!-- /.card -->
		</div>
		<!-- /.login-box -->

		<script src="{{asset('admin/assets/plugins/jquery/jquery.min.js')}}" type="text/javascript"></script>
		<script src="{{asset('admin/assets/plugins/bootstrap/js/bootstrap.bundle.min.js')}}" type="text/javascript"></script>
		<script src="{{asset('admin/assets/dist/js/adminlte.min.js')}}" type="text/javascript"></script>
    </body>
</html>
