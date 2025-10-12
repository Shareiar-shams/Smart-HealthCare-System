@extends('layouts.administration.app')
@section('admin_title_content')
    {{config('app.name')}} || Edit Appointment
@endsection
@section('admin_meta')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection
@section('admin_content_header')
    <div class="col-sm-6">
        <h1 class="m-0">{{__('Edit Appointment')}}</h1>
    </div>
    <x-ad-breadcrumb :items="[
        ['label' => 'Dashboard', 'url' => route('dashboard')],
        ['label' => 'Appointments', 'url' => route('administration.appointment.index')],
        ['label' => 'Edit'],
    ]" />
@endsection
@section('admin_vendor_css')
    <!-- summernote -->
    <link rel="stylesheet" href="{{asset('assets/plugins/summernote/summernote-bs4.min.css')}}">
@endsection
@section('admin_page_css')
    <style>
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
        <div class="row">
            <div class="col-md-8 mx-auto">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Update Appointment</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('administration.appointment.update', $appointment->id) }}" method="POST" id="editAppointmentForm">
                            @csrf
                            @method('PUT')

                            <!-- Doctor Information (Read-only) -->
                            <div class="form-group mb-3">
                                <label>Doctor</label>
                                <div class="card">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-shrink-0">
                                                <div class="doctor-avatar">
                                                    {{ strtoupper(substr($appointment->doctor->user->name, 0, 2)) }}
                                                </div>
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                <h5 class="mb-1">Dr. {{ $appointment->doctor->user->name }}</h5>
                                                <p class="mb-0 text-muted">{{ $appointment->doctor->specialty }}</p>
                                                <small class="text-muted mb-2">
                                                    <i class="fas fa-star text-warning"></i>
                                                    Experience: {{ $appointment->doctor->experience_years }} years
                                                </small>
                                                <br>
                                                <small class="mb-2 text-muted">Chamber: {{ $doctor->chamber_address ?? null}}</small>
                                            </div>
                                            <div class="text-end">
                                                <strong class="text-primary">
                                                    ${{ number_format($appointment->doctor->consultation_fee, 2) }}
                                                </strong>
                                                <small class="d-block text-muted">per visit</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Date Selection -->
                            <div class="form-group mb-3">
                                <label>Appointment Date</label>
                                <input type="date" class="form-control" name="date" id="appointment_date" 
                                    value="{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('Y-m-d') }}"
                                    min="{{ date('Y-m-d') }}" 
                                    max="{{ date('Y-m-d', strtotime('+30 days')) }}"
                                    onchange="loadTimeSlots()" required>
                            </div>

                            <!-- Time Slots -->
                            <div class="form-group mb-3">
                                <label>Available Time Slots</label>
                                <div id="timeSlots" class="d-flex flex-wrap">
                                    <div class="text-center">
                                        <i class="fas fa-spinner fa-spin"></i> Loading available slots...
                                    </div>
                                </div>
                                <input type="hidden" name="time_slot" id="selected_time_slot"
                                    value="{{ json_encode(['start' => $appointment->start_at ? $appointment->start_at->format('H:i') : '', 'end' => $appointment->end_at ? $appointment->end_at->format('H:i') : '']) }}">
                            </div>

                            <!-- Reason for Visit -->
                            <div class="form-group mb-3">
                                <label>Reason for Visit</label>
                                <textarea id="summernote" class="form-control" name="reason" rows="3" required>{{ $appointment->reason }}</textarea>
                            </div>

                            <!-- Notes -->
                            <div class="form-group mb-3">
                                <label>Additional Notes (Optional)</label>
                                <textarea class="form-control" name="notes" rows="2">{{ $appointment->notes }}</textarea>
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
                                        <div id="uploaded-documents" class="mt-3" style="display: none;">
                                            <h6>Uploaded Documents:</h6>
                                            <ul class="list-group" id="documents-list"></ul>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Existing Documents Display -->
                            @if($appointment->documents->count() > 0)
                            <div class="form-group mb-3">
                                <label>Previously Uploaded Documents</label>
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            @foreach($appointment->documents as $document)
                                            <div class="col-md-6 mb-2">
                                                <div class="card border">
                                                    <div class="card-body p-2">
                                                        <div class="d-flex justify-content-between align-items-start">
                                                            <div class="flex-grow-1">
                                                                <div class="d-flex align-items-center mb-1">
                                                                    <i class="fas fa-file-{{ $document->type === 'prescription' ? 'prescription' : ($document->type === 'report' ? 'medical' : 'file-alt') }} me-2"></i>
                                                                    <span class="badge bg-{{ $document->type === 'prescription' ? 'primary' : ($document->type === 'report' ? 'info' : 'secondary') }} badge-sm">
                                                                        {{ ucfirst($document->type) }}
                                                                    </span>
                                                                </div>
                                                                <img src="{{ $document->image_url }}" alt="{{ $document->file_name }}" class="img-thumbnail" style="max-width: 200px; max-height: 100px;">
                                                                <small class="text-muted">Uploaded {{ $document->created_at->diffForHumans() }}</small>
                                                            </div>
                                                            <div class="dropdown">
                                                                <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-toggle="dropdown">
                                                                    <i class="fas fa-ellipsis-v"></i>
                                                                </button>
                                                                <ul class="dropdown-menu">
                                                                    <li><a class="dropdown-item text-danger" href="#" onclick="deleteDocument({{ $document->id }})">
                                                                        <i class="fas fa-trash me-1"></i> Delete
                                                                    </a></li>
                                                                </ul>
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
                            @endif

                            <div class="form-group d-flex justify-content-between">
                                <a href="{{ route('administration.appointment.myAppointments') }}" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left me-2"></i>Back
                                </a>
                                <button type="submit" class="btn btn-primary" id="submitBtn">
                                    <i class="fas fa-save me-2"></i>Update Appointment
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('admin_vendor_js')
@endsection
@section('admin_page_js')
    @include('admin.additionalObject.createDocumentScript')
    <script>
        function loadTimeSlots() {
            const date = $('#appointment_date').val();
            const doctorId = {{ $appointment->doctor_id }};
            const currentSlot = JSON.parse($('#selected_time_slot').val());

            if (!date || !doctorId) return;

            $('#timeSlots').html('<div class="text-center"><i class="fas fa-spinner fa-spin"></i> Loading available slots...</div>');

            $.get(`/api/doctor/${doctorId}/time-slots`, { 
                date: date,
                current_appointment_id: {{ $appointment->id }}
            }, function(response) {
                let slotsHtml = '';
                if (response.slots.length > 0) {
                    response.slots.forEach(slot => {
                        const isCurrentSlot = slot.start === currentSlot.start && slot.end === currentSlot.end;
                        slotsHtml += `
                            <div class="time-slot ${slot.available || isCurrentSlot ? '' : 'unavailable'} 
                                                ${isCurrentSlot ? 'selected' : ''}"
                                onclick="${slot.available || isCurrentSlot ? `selectTimeSlot('${slot.start}', '${slot.end}')` : ''}"
                                data-start="${slot.start}" data-end="${slot.end}">
                                ${slot.formatted_time}
                            </div>`;
                    });
                } else {
                    slotsHtml = '<p class="text-muted">No available slots for selected date</p>';
                }
                $('#timeSlots').html(slotsHtml);

                // Highlight the current time slot after slots are loaded
                setTimeout(() => {
                    highlightCurrentTimeSlot();
                }, 100);
            });
        }

        function selectTimeSlot(start, end) {
            $('.time-slot').removeClass('selected');
            $(`[data-start="${start}"]`).addClass('selected');
            $('#selected_time_slot').val(JSON.stringify({start, end}));
        }

        function highlightCurrentTimeSlot() {
            const currentSlot = JSON.parse($('#selected_time_slot').val() || '{}');

            if (currentSlot.start && currentSlot.end) {
                // Remove existing selections
                $('.time-slot').removeClass('selected');

                // Try to find and highlight the current slot
                let currentSlotElement = $(`.time-slot[data-start="${currentSlot.start}"][data-end="${currentSlot.end}"]`);

                if (currentSlotElement.length > 0) {
                    currentSlotElement.addClass('selected');
                    console.log('Current slot highlighted:', currentSlot.start, currentSlot.end);
                } else {
                    console.log('Current slot not found in available slots:', currentSlot.start, currentSlot.end);
                    console.log('Available slots:', $('.time-slot').map((i, el) => $(el).data('start') + ' - ' + $(el).data('end')).get());
                }
            }
        }

        function validateForm() {
            const isValid = $('#appointment_date').val() && 
                            $('#selected_time_slot').val() &&
                            $('textarea[name="reason"]').val();

            $('#submitBtn').prop('disabled', !isValid);
            return isValid;
        }

        $(document).ready(function() {
            // Load initial time slots
            loadTimeSlots();

            // Form validation
            $('textarea[name="reason"]').on('input', validateForm);
            $('#appointment_date').on('change', validateForm);

            // Form submission
            $('#editAppointmentForm').on('submit', function(e) {
                if (!validateForm()) {
                    e.preventDefault();
                    alert('Please fill in all required fields');
                }
            });

            // Ensure current time slot is properly highlighted after slots load
            setTimeout(() => {
                highlightCurrentTimeSlot();
            }, 500);
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
                url: '{{ route("administration.appointment.documents.store", $appointment->id) }}',
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

        function deleteDocument(documentId) {
            var url = "{{ route('administration.appointment.documents.destroy', ':id') }}";
            url = url.replace(':id', documentId);
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this deletion!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Send delete request
                    $.ajax({
                        url: url,
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Deleted!',
                                text: 'Document has been deleted successfully.'
                            });

                            // Reload page to update the list
                            setTimeout(() => {
                                window.location.reload();
                            }, 1500);
                        },
                        error: function(xhr) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Delete Failed',
                                text: 'Failed to delete document. Please try again.'
                            });
                        }
                    });
                }
            });
        }
    </script>
@endsection