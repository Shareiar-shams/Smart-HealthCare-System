@extends('layouts.administration.app')
@section('admin_title_content')
    {{config(app.name)}} || All Prescription
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
    <
@endsection

@section('main_content')
    <!-- container-fluid -->
	<div class="container-fluid">
        
    </div>
    <!-- /.container-fluid -->
@endsection
@section('admin_vendor_js')
@endsection
@section('admin_page_js')
	
@endsection