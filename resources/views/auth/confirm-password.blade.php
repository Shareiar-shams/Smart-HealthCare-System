@extends('layouts.auth.app')

@section('page_title', 'Confirm Password')
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
                
                <p class="login-box-msg">{{ __('This is a secure area of the application. Please confirm your password before continuing.') }}</p>


                <form method="POST" action="{{ route('password.confirm') }}">
                    @csrf

                    <div class="input-group mb-3">
                        <x-text-input id="password" class="mt-1 form-control"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    

                    <div class="row">
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary btn-block">{{ __('Confirm') }}</button>
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

