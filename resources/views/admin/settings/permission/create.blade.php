@extends('layouts.administration.app')
@section('admin_title_content')
    AHVision | Permissions
@endsection
@section('admin_content_header')
    <div class="col-sm-6">
        <h1 class="m-0">{{__('Permissions Create')}}</h1>
    </div><!-- /.col -->
    <!-- breadcrumb -->
    <x-ad-breadcrumb :items="[
        ['label' => 'Dashboard', 'url' => route('dashboard')],
        ['label' => 'Permissions', 'url' => route('administration.settings.rolepermission.permission.index')],
        ['label' => 'Create Permission'],
    ]" />
@endsection
@section('admin_vendor_css')
	<!-- Select2 -->
    <link rel="stylesheet" href="{{asset('assets/plugins/select2/css/select2.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">
@endsection
@section('admin_page_css')
    <style>
        .permission-check {
            transition: all 0.2s ease;
            background: #fff;
            border-color: #dee2e6;
        }
        .permission-check:hover {
            border-color: #0d6efd;
            box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.15);
        }
        .form-check-input:checked {
            background-color: #0d6efd;
            border-color: #0d6efd;
        }
        .form-switch .form-check-input {
            height: 1.5em;
            margin-top: 0.15em;
        }
        #addModuleBtn:hover {
            color: #0a58ca;
        }
    </style>
@endsection

@section('main_content')
	<!-- Display Validation Error -->
	@include('admin.validationError.error')
    <!-- container-fluid -->
	<div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2 class="h5 mb-0">Create Permission</h2>
            <div>
                <a class="btn btn-outline-secondary btn-sm" href="{{ route('administration.settings.rolepermission.permission.index') }}">
                    <i class="fa fa-angle-double-left" aria-hidden="true"></i> Back
                </a>
            </div>
        </div>
        <form action="{{route('administration.settings.rolepermission.permission.store')}}" method="post">
    		@csrf
        	<div class="row text-center">
	          	<div class="col-md-12 col-sm-12">
		            <!-- general form elements -->
		            <div class="card card-default">
		            	<div class="card-header">

				            <div class="card-tools">
				              <button type="button" class="btn btn-tool" data-card-widget="collapse">
				                <i class="fas fa-minus"></i>
				              </button>
				              
				            </div>
				        </div>
				        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label">Select Module</label>
                                <div class="d-flex align-items-center gap-2">
                                    <div class="flex-grow-1">
                                        <select class="form-control select2bs4" name="permission_module_id" id="permission_module_id" style="width: 100%;" data-placeholder="Select a Module">
                                            <option value="">Select Module</option>
                                            @foreach ($modules as $module) 
                                                <option value="{{ $module->id }}">{{ $module->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <a href="javascript:void(0)" class="text-primary text-decoration-none d-flex align-items-center" id="addModuleBtn">
                                        <i class="fa fa-plus-circle me-1"></i>
                                        <span class="d-none d-md-inline">New Module</span>
                                    </a>
                                </div>
                                <small class="text-muted mt-1 d-block">Choose an existing module or click the plus icon to create one.</small>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-12">
                                    <div class="card shadow-sm p-3">
                                        <div class="border-bottom pb-3 mb-3">
                                            <div class="d-flex align-items-center">
                                                <div class="form-check me-4">
                                                    <input class="form-check-input" type="checkbox" checked name="name[Everything]" id="permissionEverything" />
                                                    <label class="form-check-label fw-semibold" for="permissionEverything">Everything</label>
                                                </div>
                                                <div class="text-muted small">Toggle to grant or revoke all permissions at once</div>
                                            </div>
                                        </div>
                                        <div class="row g-3">
                                            <div class="col-md-3 col-sm-6">
                                                <div class="permission-check p-2 rounded border">
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input permission-item" type="checkbox" role="switch" checked name="name[Create]" id="permissionCreate" />
                                                        <label class="form-check-label" for="permissionCreate">Create</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-sm-6">
                                                <div class="permission-check p-2 rounded border">
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input permission-item" type="checkbox" role="switch" checked name="name[Read]" id="permissionRead" />
                                                        <label class="form-check-label" for="permissionRead">Read</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-sm-6">
                                                <div class="permission-check p-2 rounded border">
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input permission-item" type="checkbox" role="switch" checked name="name[Update]" id="permissionUpdate" />
                                                        <label class="form-check-label" for="permissionUpdate">Update</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-sm-6">
                                                <div class="permission-check p-2 rounded border">
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input permission-item" type="checkbox" role="switch" checked name="name[Delete]" id="permissionDelete" />
                                                        <label class="form-check-label" for="permissionDelete">Delete</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
		                </div>
		                <!-- /.card-body -->
		            </div>
		            <!-- /.card -->

		            <!-- general form elements -->
		            <div class="card">
		            	<!-- /.card-body -->
		                <div class="card-footer">
		                  	<a href="{{route('administration.settings.rolepermission.permission.index')}}" class="btn btn-default float-right">Cancel</a>
                            <button type="submit" class="btn btn-primary">Create Permission</button>
		                </div>
		                <!-- /.card-footer -->
		            </div>
		            <!-- /.card -->
		        </div>
        	</div>
        </form>
        <!-- /.row -->
    </div><!-- /.container-fluid -->

    <!-- Add New Module Modal -->
   
    <div class="modal fade show" id="addNewPermissionModuleModal" tabindex="-1" aria-hidden="true" aria-modal="true" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content p-3 p-md-5">
                <div class="modal-header">
                    <h4 class="modal-title">Add New Module</h4>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="text-center mb-4">
                        <p class="text-muted">Create a new permission module without leaving this page.</p>
                    </div>
                    <!-- Add New Module form -->
                    <form method="post" id="addModuleForm" action="{{ route('administration.settings.rolepermission.permission.module.store') }}" class="row g-3" autocomplete="off">
                        @csrf
                        <div id="addModuleErrors" class="col-12"></div>
                        <div class="col-12 mb-4">
                            <label class="form-label">Module Name <strong class="text-danger">*</strong></label>
                            <input type="text" name="name" value="{{ old('name') }}" class="form-control" placeholder="Enter a Name" tabindex="-1" required/>
                            @error('name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-12 text-center mt-4">
                            <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
                            <button type="submit" class="btn btn-primary me-sm-3 me-1">Create Module</button>
                        </div>
                    </form>
                    <!--/ Add New Module form -->
                </div>
            </div>
        </div>
    </div>
    <!--/ Add New Module Modal -->
@endsection

@section('admin_page_js')
    @include('admin.additionalObject.createDocumentScript')

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            
            // Also open modal when clicking add buttons
            $('#addModuleBtn, #openAddModuleBtn').on('click', function () {
                $('#addNewPermissionModuleModal').modal('show');
            });


            // "Everything" toggles all permission items
            $('#permissionEverything').on('change', function () {
                var checked = $(this).is(':checked');
                $('.permission-item').prop('checked', checked);
            });

            // If any individual permission is changed, update the Everything checkbox
            $('.permission-item').on('change', function () {
                var all = $('.permission-item').length === $('.permission-item:checked').length;
                $('#permissionEverything').prop('checked', all);
            });
        });
    </script>
@endsection