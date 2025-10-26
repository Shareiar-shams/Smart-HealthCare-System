@extends('layouts.administration.app')

@section('title_content')
    {{config('app.name')}} || Select Pharmacy
@endsection

@section('content_header')
    <div class="col-sm-6">
        <h1 class="m-0">Select Pharmacy</h1>
    </div>
    <x-ad-breadcrumb :items="[
        ['label' => 'Dashboard', 'url' => route('dashboard')],
        ['label' => 'Prescription', 'url' => route('administration.prescriptions.show', $prescription->appointment_id)],
        ['label' => 'Order Medicine', 'url' => '#'],
    ]" />
@endsection

@section('admin_page_css')
    <style>
        :root {
            --bs-primary: #007bff;
            --bs-primary-rgb: 0, 123, 255;
            --pharmacy-selected-bg: #e7f3ff;
            --pharmacy-selected-border: #007bff;
            --pharmacy-selected-text: #0056b3;
        }

        .pharmacy-card {
            border: 2px solid #e9ecef;
            transition: all 0.3s ease;
            cursor: pointer;
            background: #fff;
        }

        .pharmacy-card:hover {
            border-color: var(--bs-primary);
            box-shadow: 0 4px 12px rgba(0, 123, 255, 0.15);
            transform: translateY(-2px);
        }

        /* Beautiful selected state for pharmacy cards */
        .pharmacy-card input[type="radio"]:checked + .form-check-label {
            background: linear-gradient(135deg, var(--pharmacy-selected-bg) 0%, #f0f8ff 100%) !important;
            color: var(--pharmacy-selected-text) !important;
            border: 2px solid var(--pharmacy-selected-border) !important;
            border-radius: 12px !important;
            padding: 1.25rem !important;
            box-shadow: 0 6px 20px rgba(0, 123, 255, 0.25) !important;
            position: relative !important;
            transform: scale(1.02);
        }

        .pharmacy-card input[type="radio"]:checked + .form-check-label::before {
            content: '';
            position: absolute;
            top: -1px;
            left: -1px;
            right: -1px;
            bottom: -1px;
            background: linear-gradient(135deg, var(--bs-primary), #0056b3);
            border-radius: 12px;
            z-index: -1;
            opacity: 0.1;
        }

        /* Ensure all text elements have proper contrast */
        .pharmacy-card input[type="radio"]:checked + .form-check-label * {
            color: var(--pharmacy-selected-text) !important;
            background: transparent !important;
        }

        /* Specific styling for pharmacy info */
        .pharmacy-card input[type="radio"]:checked + .form-check-label .pharmacy-info h6 {
            color: var(--bs-primary) !important;
            font-weight: 600 !important;
            font-size: 1.1em !important;
        }

        .pharmacy-card input[type="radio"]:checked + .form-check-label .pharmacy-info p {
            color: var(--pharmacy-selected-text) !important;
            font-weight: 500 !important;
        }

        /* Icons styling */
        .pharmacy-card input[type="radio"]:checked + .form-check-label .fas,
        .pharmacy-card input[type="radio"]:checked + .form-check-label .fa {
            color: var(--bs-primary) !important;
            opacity: 1 !important;
            font-size: 1.1em !important;
        }

        /* Custom radio button styling */
        .pharmacy-card .form-check-input {
            position: absolute;
            opacity: 0;
            width: 0;
            height: 0;
        }

        .pharmacy-card .form-check-input + .form-check-label::before {
            content: '';
            position: absolute;
            top: 10px;
            right: 10px;
            width: 20px;
            height: 20px;
            border: 2px solid #ddd;
            border-radius: 50%;
            background: white;
            transition: all 0.3s ease;
        }

        .pharmacy-card .form-check-input:checked + .form-check-label::after {
            content: '';
            position: absolute;
            top: 15px;
            right: 15px;
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background: var(--bs-primary);
            transition: all 0.3s ease;
        }

        .pharmacy-card {
            position: relative;
        }

        .medicine-card {
            background: #f8f9fa;
            border-left: 4px solid var(--bs-primary);
            padding: 1rem;
            border-radius: 8px;
            height: 100%;
        }
    </style>
@endsection

@section('main_content')
    <div class="container-fluid">
        @include('admin.validationError.error')
        <!-- Prescription Summary -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-prescription me-2"></i>
                            Prescription Summary
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <p class="mb-2"><strong>Prescription ID:</strong> #{{ $prescription->id }}</p>
                                <p class="mb-2"><strong>Patient:</strong> {{ $prescription->patient->name ?? 'N/A' }}</p>
                                <p class="mb-2"><strong>Doctor:</strong> Dr. {{ $prescription->doctor->user->name ?? 'N/A' }}</p>
                            </div>
                            <div class="col-md-6">
                                <p class="mb-2"><strong>Date:</strong> {{ $prescription->created_at->format('M d, Y') }}</p>
                                <p class="mb-2"><strong>Medicines:</strong> {{ $prescription->items->count() }} items</p>
                                @if($prescription->diagnosis)
                                    <p class="mb-0"><strong>Diagnosis:</strong> {{ Str::limit($prescription->diagnosis, 50) }}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pharmacy Selection -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-success text-white">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-map-marker-alt me-2"></i>
                            Choose Pharmacy
                        </h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('administration.orders.create', $prescription->id) }}" method="POST">
                            @csrf

                            <div class="row">
                                @foreach($pharmacies as $pharmacy)
                                    <div class="col-md-6 col-lg-4 mb-3">
                                        <div class="card pharmacy-card h-100">
                                            <div class="card-body text-center">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio"
                                                        name="pharmacy_id"
                                                        id="pharmacy_{{ $pharmacy->id }}"
                                                        value="{{ $pharmacy->id }}"
                                                        {{ $loop->first ? 'checked' : '' }}
                                                        required>
                                                    <label class="form-check-label w-100" for="pharmacy_{{ $pharmacy->id }}">
                                                        <div class="pharmacy-info">
                                                            <h6 class="mb-2">{{ $pharmacy->pharmacy_name }}</h6>
                                                            <p class="mb-2 text-sm">
                                                                <i class="fas fa-map-marker-alt me-1"></i>
                                                                {{ $pharmacy->address }}, {{ $pharmacy->city }}, {{$pharmacy->state}}, {{$pharmacy->postal_code}} 
                                                            </p>
                                                            <p class="mb-2 text-sm">
                                                                <i class="fas fa-phone me-1"></i>
                                                                {{ $pharmacy->phone }}
                                                            </p>
                                                            @if($pharmacy->user->email)
                                                                <p class="mb-0 text-sm">
                                                                    <i class="fas fa-envelope me-1"></i>
                                                                    {{ $pharmacy->user->email }}
                                                                </p>
                                                            @endif
                                                        </div>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            @error('pharmacy_id')
                                <div class="text-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Order Details Form -->
            <div class="row mt-4">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header bg-info text-white">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-truck me-2"></i>
                                Delivery Information
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="delivery_address" class="form-label">Delivery Address *</label>
                                        <textarea class="form-control" id="delivery_address" name="delivery_address"
                                                rows="3" placeholder="Enter complete delivery address" required>{{ old('delivery_address') }}</textarea>
                                        @error('delivery_address')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="special_instructions" class="form-label">Special Instructions</label>
                                        <textarea class="form-control" id="special_instructions" name="special_instructions"
                                                rows="3" placeholder="Any special delivery instructions">{{ old('special_instructions') }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header bg-warning text-dark">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-credit-card me-2"></i>
                                Payment Method
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="radio" name="payment_method" id="cash" value="cash" {{ old('payment_method', 'cash') == 'cash' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="cash">
                                        <i class="fas fa-money-bill-wave me-2"></i>Cash on Delivery
                                    </label>
                                </div>
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="radio" name="payment_method" id="card" value="card" {{ old('payment_method') == 'card' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="card">
                                        <i class="fas fa-credit-card me-2"></i>Credit/Debit Card
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="payment_method" id="online" value="online" {{ old('payment_method') == 'online' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="online">
                                        <i class="fas fa-mobile-alt me-2"></i>Online Payment
                                    </label>
                                </div>
                                @error('payment_method')
                                    <div class="text-danger mt-2">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Medicine List Preview -->
            <div class="row mt-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header bg-secondary text-white">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-pills me-2"></i>
                                Medicines to Order
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                @foreach($prescription->items as $item)
                                    <div class="col-md-6 mb-3">
                                        <div class="medicine-card">
                                            <div class="d-flex justify-content-between align-items-start">
                                                <div>
                                                    <h6 class="mb-1">{{ $item->medicine_name }}</h6>
                                                    <p class="mb-1 text-sm">
                                                        <strong>Dosage:</strong> {{ $item->dosage }}
                                                    </p>
                                                    <p class="mb-1 text-sm">
                                                        <strong>Duration:</strong> {{ $item->duration }}
                                                    </p>
                                                    <p class="mb-0 text-sm">
                                                        <strong>Frequency:</strong> {{ $item->frequency }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="row mt-4">
                <div class="col-12 text-center">
                    <button type="submit" class="btn btn-success btn-lg me-3">
                        <i class="fas fa-shopping-cart me-2"></i>Place Order
                    </button>
                    <a href="{{ route('administration.prescriptions.show', $prescription->appointment_id) }}" class="btn btn-outline-secondary btn-lg">
                        <i class="fas fa-arrow-left me-2"></i>Back to Prescription
                    </a>
                </div>
            </div>
        </form>
    </div>
@endsection
