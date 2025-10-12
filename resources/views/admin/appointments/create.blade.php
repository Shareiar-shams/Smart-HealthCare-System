@extends('layouts.administration.app')
@section('admin_title_content')
    {{config('app.name')}} || Create Appointment
@endsection
@section('admin_meta')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection
@section('admin_content_header')
    <div class="col-sm-6">
        <h1 class="m-0">{{__('Create Appointment')}}</h1>
    </div>
    <x-ad-breadcrumb :items="[
        ['label' => 'Dashboard', 'url' => route('dashboard')],
        ['label' => 'Appointments', 'url' => route('administration.appointment.index')],
        ['label' => 'Create'],
    ]" />
@endsection
@section('admin_vendor_css')
    <!-- summernote -->
    <link rel="stylesheet" href="{{asset('assets/plugins/summernote/summernote-bs4.min.css')}}">
@endsection
@section('admin_page_css')
    <style>
        .doctor-card {
            cursor: pointer;
            transition: all 0.3s ease;
        }
        .doctor-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        .doctor-card.selected {
            border: 2px solid var(--bs-primary);
        }
        .time-slot {
            cursor: pointer;
            padding: 10px;
            margin: 5px;
            border: 1px solid #dee2e6;
            border-radius: 5px;
            transition: all 0.2s;
        }
        .time-slot:hover {
            background-color: #e9ecef;
        }
        .time-slot.selected {
            background-color: var(--bs-primary);
            color: white;
        }
        .time-slot.unavailable {
            background-color: #f8f9fa;
            color: #adb5bd;
            cursor: not-allowed;
        }
        .border-dashed {
            border-style: dashed !important;
        }
        .document-upload-item {
            transition: all 0.3s ease;
        }
        .document-upload-item:hover {
            background-color: #f8f9fa;
        }
    </style>
@endsection

@section('main_content')
    <div class="container-fluid">
        <form action="{{ route('administration.appointment.store') }}" method="POST" id="appointmentForm">
            @csrf
            <div class="row">
                <!-- Doctor Selection -->
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Select Doctor</h3>
                            <div class="card-tools">
                                <div class="input-group">
                                    <input type="text" class="form-control form-control-sm" id="doctorSearch" 
                                        placeholder="Search doctor...">
                                    <select class="form-control form-control-sm ml-2" id="specialtyFilter">
                                        <option value="">All Specialties</option>
                                        @foreach($specialties as $specialty)
                                            <option value="{{ $specialty }}">{{ $specialty }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row" id="doctorsList">
                                @foreach($doctors as $doctor)
                                    <div class="col-md-6 mb-3 doctor-item" 
                                        data-specialty="{{ $doctor->specialty }}"
                                        data-name="{{ $doctor->user->name }}">
                                        <div class="card doctor-card" onclick="selectDoctor({{ $doctor->id }})">
                                            <div class="card-body">
                                                <div class="d-flex align-items-center">
                                                    <div class="flex-shrink-0">
                                                        <div class="doctor-avatar">
                                                            {{ strtoupper(substr($doctor->user->name, 0, 2)) }}
                                                        </div>
                                                    </div>
                                                    <div class="flex-grow-1 ms-3">
                                                        <h5 class="mb-1">Dr. {{ $doctor->user->name }}</h5>
                                                        <p class="mb-0 text-muted">{{ $doctor->specialty }}</p>
                                                        
                                                        <small class="text-muted">
                                                            <i class="fas fa-star text-warning"></i>
                                                            Experience: {{ $doctor->experience_years }} years
                                                        </small>
                                                        <small class="mb-2 text-muted">Chamber: {{ $doctor->chamber_address ?? null}}</small>
                                                    </div>
                                                    <div class="doctor-fee text-end">
                                                        <strong class="text-primary">
                                                            ${{ number_format($doctor->consultation_fee, 2) }}
                                                        </strong>
                                                        <small class="d-block text-muted">per visit</small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Appointment Details -->
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Appointment Details</h3>
                        </div>
                        <div class="card-body">
                            <input type="hidden" name="doctor_id" id="selected_doctor_id">
                            
                            <!-- Date Selection -->
                            <div class="form-group mb-3">
                                <label>Select Date</label>
                                <input type="date" class="form-control" name="date" id="appointment_date" 
                                    min="{{ date('Y-m-d') }}" 
                                    max="{{ date('Y-m-d', strtotime('+30 days')) }}"
                                    onchange="loadTimeSlots()" required>
                            </div>

                            <!-- Time Slots -->
                            <div class="form-group mb-3">
                                <label>Available Time Slots</label>
                                <div id="timeSlots" class="d-flex flex-wrap">
                                    <p class="text-muted">Please select a doctor and date first</p>
                                </div>
                                <input type="hidden" name="time_slot" id="selected_time_slot">
                            </div>

                            <!-- Reason for Visit -->
                            <div class="form-group mb-3">
                                <label>Reason for Visit</label>
                                <textarea id="summernote" class="form-control" name="reason" rows="3" required></textarea>
                            </div>

                            <!-- Notes -->
                            <div class="form-group mb-3">
                                <label>Additional Notes (Optional)</label>
                                <textarea class="form-control" name="notes" rows="2"></textarea>
                            </div>

                            <!-- Document Upload Section -->
                            <div class="form-group mb-3">
                                <label>Upload Documents (Optional)</label>
                                <div class="card">
                                    <div class="card-body">
                                        <p class="text-muted small mb-3">
                                            You can upload test reports, previous prescriptions, or doctor's suggestions to help your doctor understand your medical history better.
                                        </p>

                                        <!-- Document Upload Area -->
                                        <div id="document-upload-area" class="border-dashed border-2 border-primary p-3 mb-3 text-center">
                                            <i class="fas fa-cloud-upload-alt fa-2x text-primary mb-2"></i>
                                            <p class="mb-2">Drag & drop files here or click to browse</p>
                                            <input type="file" id="document-files" multiple accept=".pdf,.jpg,.jpeg,.png" style="display: none;">
                                            <button type="button" class="btn btn-outline-primary btn-sm" onclick="document.getElementById('document-files').click()">
                                                <i class="fas fa-folder-open me-1"></i>Choose Files
                                            </button>
                                        </div>

                                        <!-- Document Type Selection -->
                                        <div class="mb-3">
                                            <label class="form-label">Document Type</label>
                                            <select class="form-control" id="document-type">
                                                <option value="report">Medical Report</option>
                                                <option value="prescription">Previous Prescription</option>
                                                <option value="suggestion">Doctor's Suggestion</option>
                                            </select>
                                        </div>

                                        <!-- Upload Button -->
                                        <button type="button" class="btn btn-success btn-sm w-100" id="upload-documents-btn" onclick="uploadDocuments()">
                                            <i class="fas fa-upload me-2"></i>Upload Documents
                                        </button>

                                        <!-- Uploaded Documents List -->
                                        <div id="uploaded-documents" class="mt-3">
                                            <h6>Uploaded Documents:</h6>
                                            <ul class="list-group" id="documents-list"></ul>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary w-100" id="submitBtn" disabled>
                                <i class="fas fa-calendar-check me-2"></i>Book Appointment
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection

@section('admin_vendor_js')
@endsection
@section('admin_page_js')
    @include('admin.additionalObject.createDocumentScript')
    <script>
        let selectedDoctor = null;

        function selectDoctor(doctorId) {
            selectedDoctor = doctorId;
            $('.doctor-card').removeClass('selected');
            $(`.doctor-card[onclick="selectDoctor(${doctorId})"]`).addClass('selected');
            $('#selected_doctor_id').val(doctorId);
            loadTimeSlots();
            validateForm();
        }

        function loadTimeSlots() {
            const date = $('#appointment_date').val();
            const doctorId = $('#selected_doctor_id').val();

            if (!date || !doctorId) return;

            // Show loading state
            $('#timeSlots').html('<div class="text-center"><i class="fas fa-spinner fa-spin"></i> Loading available slots...</div>');

            $.get(`/api/doctor/${doctorId}/time-slots`, { date: date }, function(response) {
                let slotsHtml = '';
                if (response.slots.length > 0) {
                    response.slots.forEach(slot => {
                        slotsHtml += `
                            <div class="time-slot ${slot.available ? '' : 'unavailable'}"
                                onclick="${slot.available ? `selectTimeSlot('${slot.start}', '${slot.end}')` : ''}"
                                data-start="${slot.start}" data-end="${slot.end}">
                                ${slot.formatted_time}
                            </div>`;
                    });
                } else {
                    slotsHtml = '<p class="text-muted">No available slots for selected date</p>';
                }
                $('#timeSlots').html(slotsHtml);
            });
        }

        function selectTimeSlot(start, end) {
            $('.time-slot').removeClass('selected');
            $(`[data-start="${start}"]`).addClass('selected');
            $('#selected_time_slot').val(JSON.stringify({start, end}));
            validateForm();
        }

        function validateForm() {
            const doctorId = $('#selected_doctor_id').val();
            const date = $('#appointment_date').val();
            const timeSlot = $('#selected_time_slot').val();
            const reason = $('textarea[name="reason"]').val();

            // console.log('Validation Check:', {
            //     doctorId: doctorId,
            //     date: date,
            //     timeSlot: timeSlot,
            //     reason: reason
            // });

            const isValid = doctorId && date && timeSlot && reason && reason.trim() !== '';
            
            $('#submitBtn').prop('disabled', !isValid);
            return isValid;
        }

        $(document).ready(function() {
            // Initial form validation
            validateForm();

            // Doctor search
            $('#doctorSearch').on('input', function() {
                const searchTerm = $(this).val().toLowerCase();
                $('.doctor-item').each(function() {
                    const doctorName = $(this).data('name').toLowerCase();
                    $(this).toggle(doctorName.includes(searchTerm));
                });
            });

            // Specialty filter
            $('#specialtyFilter').change(function() {
                const specialty = $(this).val();
                $('.doctor-item').each(function() {
                    if (!specialty || $(this).data('specialty') === specialty) {
                        $(this).show();
                    } else {
                        $(this).hide();
                    }
                });
            });

            // Form validation
            $('textarea[name="reason"]').on('input', validateForm);

            // Form submission
            $('#appointmentForm').on('submit', function(e) {
                e.preventDefault();

                if (!validateForm()) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Required Fields Missing',
                        text: 'Please fill in all required fields:' +
                            (!$('#selected_doctor_id').val() ? '\n- Select a doctor' : '') +
                            (!$('#appointment_date').val() ? '\n- Select a date' : '') +
                            (!$('#selected_time_slot').val() ? '\n- Select a time slot' : '') +
                            (!$('textarea[name="reason"]').val() ? '\n- Enter reason for visit' : ''),
                        confirmButtonText: 'OK'
                    });
                    return false;
                }

                // If validation passes, submit the form
                this.submit();
            });
        });

        // Document upload functionality
        let selectedFiles = [];

        // Handle file selection
        $('#document-files').on('change', function() {
            handleFileSelection(this.files);
        });

        // Drag and drop functionality
        $('#document-upload-area').on('dragover dragenter', function(e) {
            e.preventDefault();
            $(this).addClass('border-success bg-light');
        });

        $('#document-upload-area').on('dragleave dragend', function(e) {
            e.preventDefault();
            $(this).removeClass('border-success bg-light');
        });

        $('#document-upload-area').on('drop', function(e) {
            e.preventDefault();
            $(this).removeClass('border-success bg-light');

            const files = e.originalEvent.dataTransfer.files;
            $('#document-files')[0].files = files;
            handleFileSelection(files);
        });

        function handleFileSelection(files) {
            selectedFiles = Array.from(files);
            updateFilePreview();
        }

        function updateFilePreview() {
            const container = $('#documents-list');
            container.empty();

            if (selectedFiles.length === 0) {
                $('#uploaded-documents').hide();
                return;
            }

            $('#uploaded-documents').show();

            selectedFiles.forEach((file, index) => {
                const fileItem = `
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            <i class="fas fa-file-${getFileIcon(file.type)} me-2"></i>
                            <strong>${file.name}</strong>
                            <br>
                            <small class="text-muted">${formatFileSize(file.size)}</small>
                        </div>
                        <button type="button" class="btn btn-sm btn-outline-danger" onclick="removeFile(${index})">
                            <i class="fas fa-times"></i>
                        </button>
                    </li>
                `;
                container.append(fileItem);
            });
        }

        function getFileIcon(mimeType) {
            if (mimeType.includes('pdf')) return 'pdf';
            if (mimeType.includes('image')) return 'image';
            return 'alt';
        }

        function formatFileSize(bytes) {
            if (bytes === 0) return '0 Bytes';
            const k = 1024;
            const sizes = ['Bytes', 'KB', 'MB', 'GB'];
            const i = Math.floor(Math.log(bytes) / Math.log(k));
            return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
        }

        function removeFile(index) {
            selectedFiles.splice(index, 1);
            updateFilePreview();
        }

        function uploadDocuments() {
            if (selectedFiles.length === 0) {
                Swal.fire({
                    icon: 'warning',
                    title: 'No Files Selected',
                    text: 'Please select files to upload first.'
                });
                return;
            }

            const documentType = $('#document-type').val();
            const uploadBtn = $('#upload-documents-btn');
            const originalText = uploadBtn.html();

            // Show loading state
            uploadBtn.html('<i class="fas fa-spinner fa-spin me-2"></i>Uploading...').prop('disabled', true);

            // Create FormData for file upload
            const formData = new FormData();
            selectedFiles.forEach((file, index) => {
                formData.append(`files[${index}]`, file);
            });
            formData.append('type', documentType);

            // Upload files
            $.ajax({
                url: '{{ route("administration.appointment.documents.store", "__APPOINTMENT_ID__") }}'.replace('__APPOINTMENT_ID__', 'temp'),
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Upload Successful',
                        text: `${selectedFiles.length} document(s) uploaded successfully!`
                    });

                    // Clear selected files
                    selectedFiles = [];
                    $('#document-files').val('');
                    updateFilePreview();

                    // Reload page to show uploaded documents
                    setTimeout(() => {
                        window.location.reload();
                    }, 1500);
                },
                error: function(xhr) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Upload Failed',
                        text: 'Failed to upload documents. Please try again.'
                    });
                },
                complete: function() {
                    // Restore button state
                    uploadBtn.html(originalText).prop('disabled', false);
                }
            });
        }
    </script>
@endsection