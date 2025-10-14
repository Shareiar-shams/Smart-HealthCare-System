@extends('layouts.administration.app')

@section('admin_title_content')
    {{config('app.name')}} || Order Confirmation
@endsection

@section('admin_content_header')
    <div class="col-sm-6">
        <h1 class="m-0">Order Confirmation</h1>
    </div>
    <x-ad-breadcrumb :items="[
        ['label' => 'Dashboard', 'url' => route('dashboard')],
        ['label' => 'My Orders', 'url' => route('administration.orders.index')],
        ['label' => 'Order Confirmation'],
    ]" />
@endsection

@section('main_content')
<div class="container-fluid">
    <!-- Success Message -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i>
                <strong>Order Placed Successfully!</strong> Your medicine order has been placed and is being processed.
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        </div>
    </div>

    <!-- Order Details -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h4 class="card-title mb-0">
                        <i class="fas fa-receipt me-2"></i>
                        Order Details
                    </h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p class="mb-2"><strong>Order ID:</strong> #{{ $order->id }}</p>
                            <p class="mb-2"><strong>Prescription ID:</strong> #{{ $order->prescription_id }}</p>
                            <p class="mb-2"><strong>Order Date:</strong> {{ $order->created_at->format('M d, Y h:i A') }}</p>
                            <p class="mb-2"><strong>Status:</strong>
                                <span class="badge bg-warning">{{ ucfirst($order->status) }}</span>
                            </p>
                        </div>
                        <div class="col-md-6">
                            <p class="mb-2"><strong>Pharmacy:</strong> {{ $order->pharmacy->name ?? 'N/A' }}</p>
                            <p class="mb-2"><strong>Payment Method:</strong> {{ ucfirst($order->payment_method) }}</p>
                            <p class="mb-2"><strong>Payment Status:</strong>
                                <span class="badge bg-info">{{ ucfirst($order->payment_status) }}</span>
                            </p>
                            <p class="mb-0"><strong>Total Amount:</strong> ${{ number_format($order->total_price, 2) }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Pharmacy Information -->
    @if($order->pharmacy)
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-success text-white">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-map-marker-alt me-2"></i>
                        Pharmacy Information
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="mb-2">{{ $order->pharmacy->name }}</h6>
                            <p class="mb-2">
                                <i class="fas fa-map-marker-alt me-1"></i>
                                {{ $order->pharmacy->address }}
                            </p>
                            <p class="mb-2">
                                <i class="fas fa-phone me-1"></i>
                                {{ $order->pharmacy->phone }}
                            </p>
                            @if($order->pharmacy->email)
                                <p class="mb-0">
                                    <i class="fas fa-envelope me-1"></i>
                                    {{ $order->pharmacy->email }}
                                </p>
                            @endif
                        </div>
                        <div class="col-md-6">
                            <h6 class="mb-3">Delivery Address</h6>
                            <p class="mb-0">{{ $order->delivery_address }}</p>
                            @if($order->special_instructions)
                                <div class="mt-3">
                                    <strong>Special Instructions:</strong>
                                    <p class="mb-0">{{ $order->special_instructions }}</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Order Items -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-info text-white">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-pills me-2"></i>
                        Order Items
                    </h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>Medicine Name</th>
                                    <th>Dosage</th>
                                    <th>Quantity</th>
                                    <th>Price per Unit</th>
                                    <th>Total Price</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->items as $item)
                                    <tr>
                                        <td>
                                            <strong>{{ $item->medicine_name }}</strong>
                                        </td>
                                        <td>{{ $item->dosage }}</td>
                                        <td>{{ $item->quantity }}</td>
                                        <td>${{ number_format($item->price, 2) }}</td>
                                        <td>${{ number_format($item->quantity * $item->price, 2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="table-light">
                                <tr>
                                    <th colspan="4" class="text-end">Total Amount:</th>
                                    <th>${{ number_format($order->total_price, 2) }}</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Prescription Information -->
    @if($order->prescription)
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-secondary text-white">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-prescription me-2"></i>
                        Prescription Information
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p class="mb-2"><strong>Patient:</strong> {{ $order->prescription->patient->name ?? 'N/A' }}</p>
                            <p class="mb-2"><strong>Doctor:</strong> Dr. {{ $order->prescription->doctor->user->name ?? 'N/A' }}</p>
                            @if($order->prescription->diagnosis)
                                <p class="mb-0"><strong>Diagnosis:</strong> {{ $order->prescription->diagnosis }}</p>
                            @endif
                        </div>
                        <div class="col-md-6">
                            @if($order->prescription->instructions)
                                <p class="mb-0"><strong>Instructions:</strong> {{ $order->prescription->instructions }}</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Order Status Information -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-warning text-dark">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-info-circle me-2"></i>
                        What's Next?
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 text-center">
                            <div class="mb-3">
                                <i class="fas fa-clock fa-2x text-warning"></i>
                            </div>
                            <h6>Order Processing</h6>
                            <p class="text-sm">Your order is being processed by the pharmacy</p>
                        </div>
                        <div class="col-md-4 text-center">
                            <div class="mb-3">
                                <i class="fas fa-box fa-2x text-info"></i>
                            </div>
                            <h6>Medicine Preparation</h6>
                            <p class="text-sm">Pharmacy is preparing your medicines</p>
                        </div>
                        <div class="col-md-4 text-center">
                            <div class="mb-3">
                                <i class="fas fa-truck fa-2x text-success"></i>
                            </div>
                            <h6>Delivery</h6>
                            <p class="text-sm">Your order will be delivered to your address</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="row">
        <div class="col-12 text-center">
            <a href="{{ route('administration.orders.show', $order->id) }}" class="btn btn-primary btn-lg me-3">
                <i class="fas fa-eye me-2"></i>View Order Details
            </a>
            <a href="{{ route('administration.orders.index') }}" class="btn btn-outline-primary btn-lg me-3">
                <i class="fas fa-list me-2"></i>My Orders
            </a>
            <a href="{{ route('administration.prescriptions.show', $order->prescription->appointment_id ?? '#' ) }}" class="btn btn-outline-secondary btn-lg">
                <i class="fas fa-arrow-left me-2"></i>Back to Prescription
            </a>
        </div>
    </div>
</div>
@endsection

@section('admin_page_css')
<style>
.medicine-card {
    background: #f8f9fa;
    border-left: 4px solid var(--bs-primary);
    padding: 1rem;
    border-radius: 8px;
    margin-bottom: 1rem;
}

.table th {
    border-top: none;
    font-weight: 600;
}

.badge {
    font-size: 0.8em;
}
</style>
@endsection