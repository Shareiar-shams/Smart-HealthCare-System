@extends('layouts.auth.app')

@section('page_title', 'Verify Email')
@section('body_class', 'login-page')


@section('content')
    <div class="login-box">
        <!-- /.login-logo -->
        <div class="card card-outline card-primary">
            <div class="card-header text-center">
                <h4 class="h1"><b>Smart </b>HealthCare</h4>
                {{-- <img src="{{ asset(config('app.logo')) }}" alt="logo" height="50" class="mb-2"/> --}}
            </div>
            <div class="card-body">
                
                <p class="login-box-msg">{{ __('Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}</p>

                @if (session('status') == 'verification-link-sent')
                    <div class="mb-4 font-medium text-sm text-green-600 dark:text-green-400">
                        {{ __('A new verification link has been sent to the email address you provided during registration.') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('verification.send') }}">
                    @csrf

                    <div class="row">
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary btn-block">{{ __('Resend Verification Email') }}</button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <div class="row">
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">{{ __('Log Out') }}</button>
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
@endsection

