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
        .fade-in {
            animation: fadeIn 0.4s ease-in-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-5px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Responsive fixes */
        @media (max-width: 768px) {
            .doctor-card {
                margin-bottom: 1rem;
            }

            .card-body {
                padding: 1rem;
            }

            .document-upload-area {
                padding: 1rem !important;
            }

            .list-group-item {
                padding: 0.75rem;
            }

            #submitBtn {
                font-size: 1rem;
                padding: 0.75rem 1.5rem;
            }
        }

        /* Submit button styling */
        #submitBtn:disabled {
            background-color: #6c757d !important;
            border-color: #6c757d !important;
            cursor: not-allowed;
            opacity: 0.65;
        }

        #submitBtn:not(:disabled) {
            background-color: #007bff !important;
            border-color: #007bff !important;
            cursor: pointer;
        }

    </style>
@endsection

@section('main_content')
    <div class="container-fluid">
        <form action="{{ route('administration.appointment.store') }}" method="POST" id="appointmentForm" enctype="multipart/form-data">
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
                            <!-- Selected Doctor Info -->
                            <div id="selected-doctor-info" class="alert alert-info d-none mb-3">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-user-md fa-2x me-3 text-primary"></i>
                                    <div>
                                        <strong>Selected Doctor:</strong> <span id="selected-doctor-name" class="fw-bold"></span><br>
                                        <small id="selected-doctor-specialty" class="text-muted"></small>
                                    </div>
                                </div>
                            </div>
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
                                            <input type="file" id="document-files" name="documents[]" multiple accept=".pdf,.jpg,.jpeg,.png" style="display: none;">
                                            <button type="button" class="btn btn-outline-primary btn-sm" onclick="document.getElementById('document-files').click()">
                                                <i class="fas fa-folder-open me-1"></i>Choose Files
                                            </button>
                                        </div>

                                        <!-- Document Type Selection for each file -->
                                        <div class="mb-3">
                                            <label class="form-label">Document Types</label>
                                            <div id="document-types-container">
                                                <!-- Document type selects will be added here dynamically -->
                                            </div>
                                        </div>

                                        <!-- Uploaded Documents List -->
                                        <div id="uploaded-documents" class="mt-3" style="display: none;">
                                            <h6>Selected Documents:</h6>
                                            <div class="table-responsive">
                                                <ul class="list-group" id="documents-list"></ul>
                                            </div>
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

            // Highlight selected card
            $('.doctor-card').removeClass('selected');
            $(`.doctor-card[onclick="selectDoctor(${doctorId})"]`).addClass('selected');

            // Get doctor details from the clicked card
            const doctorCard = $(`.doctor-card[onclick="selectDoctor(${doctorId})"]`).closest('.doctor-item');
            const doctorName = doctorCard.data('name');
            const doctorSpecialty = doctorCard.data('specialty');

            // Show selected doctor info section
            $('#selected-doctor-name').text('Dr. ' + doctorName);
            $('#selected-doctor-specialty').text(doctorSpecialty);
            $('#selected-doctor-info').removeClass('d-none').addClass('fade-in');

            // Set hidden field value
            $('#selected_doctor_id').val(doctorId);

            // Reload available slots
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


        $(document).ready(function() {
            // Initial form validation
            setTimeout(() => {
                validateForm();
            }, 100);

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

            // Form validation on input changes
            $('#appointment_date').on('change', validateForm);
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
        let documentTypes = [];

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
            documentTypes = selectedFiles.map(() => 'report'); // Default type for each file
            updateFilePreview();
            updateDocumentTypeSelects();
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
                    <li class="list-group-item d-flex flex-column flex-md-row align-items-start align-items-md-center">
                        <div class="flex-grow-1 w-100 mb-2 mb-md-0">
                            <div class="d-flex align-items-center mb-2">
                                <i class="fas fa-file-${getFileIcon(file.type)} me-2"></i>
                                <strong class="text-break">${file.name}</strong>
                            </div>
                            <div class="ms-4 mb-2">
                                <select class="form-select form-select-sm document-type-select" data-index="${index}">
                                    <option value="report" ${documentTypes[index] === 'report' ? 'selected' : ''}>Medical Report</option>
                                    <option value="prescription" ${documentTypes[index] === 'prescription' ? 'selected' : ''}>Previous Prescription</option>
                                    <option value="suggestion" ${documentTypes[index] === 'suggestion' ? 'selected' : ''}>Doctor's Suggestion</option>
                                </select>
                            </div>
                            <small class="text-muted d-block">${formatFileSize(file.size)}</small>
                        </div>
                        <button type="button" class="btn btn-sm btn-outline-danger align-self-end" onclick="removeFile(${index})">
                            <i class="fas fa-times"></i> Remove
                        </button>
                    </li>
                `;
                container.append(fileItem);
            });

            // Update document types when selects change
            $('.document-type-select').on('change', function() {
                const index = $(this).data('index');
                documentTypes[index] = $(this).val();
            });
        }

        function updateDocumentTypeSelects() {
            // This function is now handled in updateFilePreview
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
            documentTypes.splice(index, 1);
            updateFilePreview();
        }

        // Update form validation to include file validation
        function validateForm() {
            const doctorId = $('#selected_doctor_id').val();
            const date = $('#appointment_date').val();
            const timeSlot = $('#selected_time_slot').val();
            const reason = $('textarea[name="reason"]').val();

            console.log('=== FORM VALIDATION DEBUG ===');
            console.log('Doctor ID:', doctorId);
            console.log('Date:', date);
            console.log('Time Slot:', timeSlot);
            console.log('Reason:', reason ? reason.substring(0, 50) + '...' : 'empty');
            console.log('Selected Files Count:', selectedFiles.length);

            // Check file sizes only if files are selected (documents are optional)
            let fileSizeValid = true;
            if (selectedFiles.length > 0) {
                const maxSize = 5 * 1024 * 1024; // 5MB
                console.log('Checking file sizes...');
                selectedFiles.forEach((file, index) => {
                    console.log(`File ${index}: ${file.name} - ${file.size} bytes`);
                    if (file.size > maxSize) {
                        console.log(`File ${index} exceeds limit!`);
                        fileSizeValid = false;
                    }
                });
            }

            // Basic validation (required fields)
            const basicValid = doctorId && date && timeSlot && reason && reason.trim() !== '';
            console.log('Basic validation (required fields):', basicValid);
            console.log('File size validation:', fileSizeValid);

            // Overall validation
            const isValid = basicValid && fileSizeValid;
            console.log('Overall validation result:', isValid);

            // Update button state
            $('#submitBtn').prop('disabled', !isValid);

            if (isValid) {
                $('#submitBtn').removeClass('btn-secondary').addClass('btn-primary');
                console.log('✅ Submit button ENABLED');
            } else {
                $('#submitBtn').removeClass('btn-primary').addClass('btn-secondary');
                console.log('❌ Submit button DISABLED');
            }

            return isValid;
        }

        // Update form submission to handle files
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
                        (!$('textarea[name="reason"]').val() ? '\n- Enter reason for visit' : '') +
                        (selectedFiles.length > 0 && selectedFiles.some(f => f.size > 5 * 1024 * 1024) ? '\n- Some files exceed 5MB limit' : ''),
                    confirmButtonText: 'OK'
                });
                return false;
            }

            // Add document types to form data
            if (selectedFiles.length > 0) {
                documentTypes.forEach((type, index) => {
                    $('<input>').attr({
                        type: 'hidden',
                        name: `document_types[${index}]`,
                        value: type
                    }).appendTo('#appointmentForm');
                });
            }

            // If validation passes, submit the form
            this.submit();
        });
    </script>
@endsection