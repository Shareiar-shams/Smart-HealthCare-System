@extends('layouts.administration.app')
@section('title_content')
    {{config('app.name')}} || Activities Log
@endsection
@section('content_header')
    <div class="col-sm-6">
        <h1 class="m-0">Dashboard</h1>
    </div><!-- /.col -->
    <!-- breadcrumb -->
    <x-ad-breadcrumb :items="[
        ['label' => 'Dashboard', 'url' => route('dashboard')],
        ['label' => 'Activities Log', 'url' => route('activities.index')],
    ]" />
@endsection
@section('admin_vendor_css')
    @include('admin.additionalObjects.datatable.datatable_css')
@endsection

@section('admin_page_css')
@endsection

@section('admin_main_content')

    <div class="container-fluid">
        <div class="row">
        	<div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Activities Log</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Description</th>
                                    <th>URL</th>
                                    <th>Created Time</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($activities as $activity)
                                    <tr>
                                        <td>{{ $activity->description }}</td>
                                        <td>{{ $activity->properties['url'] ?? 'Null' }}</td>
                                        <td>{{ $activity->created_at->diffForHumans() }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center">No activity found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
        	</div>
        	<!-- /.col -->
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
    
@endsection
@section('admin_vendor_js')

    
@endsection

@section('admin_page_js')
    @include('admin.additionalObjects.datatable.datatable_js')
@endsection
