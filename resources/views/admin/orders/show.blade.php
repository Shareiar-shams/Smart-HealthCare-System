@extends('layouts.administration.app')

@section('admin_title_content')
    {{config('app.name')}} || Order Details
@endsection

@section('admin_content_header')
    <div class="col-sm-6">
        <h1 class="m-0">Order Details</h1>
    </div>
    <x-ad-breadcrumb :items="[
        ['label' => 'Dashboard', 'url' => route('dashboard')],
        ['label' => 'My Orders', 'url' => route('administration.orders.index')],
        ['label' => 'Order Details'],
    ]" />
@endsection

@section('main_content')
<div class="container-fluid">
    <!-- Order Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="card-title mb-0">
                            <i class="fas fa-receipt me-2"></i>
                            Order #{{ $order->id }}
                        </h4>
                        <div>
                            @php
                                $statusColors = [
                                    'pending' => 'warning',
                                    'processing' => 'info',
                                    'ready' => 'primary',
                                    'out_for_delivery' => 'info',
                                    'delivered' => 'success',
                                    'cancelled' => 'danger'
                                ];
                                $statusColor = $statusColors[$order->status] ?? 'secondary';
                            @endphp
                            <span class="badge bg-{{ $statusColor }} fs-6">{{ ucfirst($order->status) }}</span>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p class="mb-2"><strong>Order Date:</strong> {{ $order->created_at->format('M d, Y h:i A') }}</p>
                            <p class="mb-2"><strong>Prescription ID:</strong> #{{ $order->prescription_id }}</p>
                            <p class="mb-2"><strong>Payment Method:</strong> {{ ucfirst($order->payment_method) }}</p>
                        </div>
                        <div class="col-md-6">
                            <p class="mb-2"><strong>Payment Status:</strong>
                                @php
                                    $paymentStatusColors = [
                                        'pending' => 'warning',
                                        'paid' => 'success',
                                        'failed' => 'danger',
                                        'refunded' => 'info'
                                    ];
                                    $paymentStatusColor = $paymentStatusColors[$order->payment_status] ?? 'secondary';
                                @endphp
                                <span class="badge bg-{{ $paymentStatusColor }}">{{ ucfirst($order->payment_status) }}</span>
                            </p>
                            <p class="mb-2"><strong>Total Amount:</strong> ${{ number_format($order->total_price, 2) }}</p>
                            @if($order->ordered_at)
                                <p class="mb-0"><strong>Ordered At:</strong> {{ $order->ordered_at->format('M d, Y h:i A') }}</p>
                            @endif
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
                            <h6 class="mb-3">Delivery Information</h6>
                            <p class="mb-2"><strong>Delivery Address:</strong></p>
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

                    <!-- Prescription Medicines -->
                    @if($order->prescription->items && $order->prescription->items->count() > 0)
                        <div class="mt-4">
                            <h6 class="mb-3">Prescribed Medicines:</h6>
                            <div class="row">
                                @foreach($order->prescription->items as $item)
                                    <div class="col-md-6 mb-3">
                                        <div class="medicine-card">
                                            <h6 class="mb-2">{{ $item->medicine_name }}</h6>
                                            <div class="row text-sm">
                                                <div class="col-6">
                                                    <strong>Dosage:</strong><br>
                                                    {{ $item->dosage }}
                                                </div>
                                                <div class="col-6">
                                                    <strong>Duration:</strong><br>
                                                    {{ $item->duration }}
                                                </div>
                                            </div>
                                            <div class="mt-2">
                                                <strong>Frequency:</strong> {{ $item->frequency }}
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Order Status Timeline -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-light">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-clock me-2"></i>
                        Order Status
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 text-center">
                            <div class="mb-3">
                                @if(in_array($order->status, ['pending', 'processing', 'ready', 'out_for_delivery', 'delivered']))
                                    <i class="fas fa-check-circle fa-2x text-success"></i>
                                @else
                                    <i class="fas fa-circle fa-2x text-muted"></i>
                                @endif
                            </div>
                            <h6>Order Placed</h6>
                            <p class="text-sm">{{ $order->created_at->format('M d, Y') }}</p>
                        </div>
                        <div class="col-md-3 text-center">
                            <div class="mb-3">
                                @if(in_array($order->status, ['processing', 'ready', 'out_for_delivery', 'delivered']))
                                    <i class="fas fa-check-circle fa-2x text-success"></i>
                                @elseif($order->status == 'pending')
                                    <i class="fas fa-clock fa-2x text-warning"></i>
                                @else
                                    <i class="fas fa-circle fa-2x text-muted"></i>
                                @endif
                            </div>
                            <h6>Processing</h6>
                            <p class="text-sm">Pharmacy is preparing medicines</p>
                        </div>
                        <div class="col-md-3 text-center">
                            <div class="mb-3">
                                @if(in_array($order->status, ['ready', 'out_for_delivery', 'delivered']))
                                    <i class="fas fa-check-circle fa-2x text-success"></i>
                                @elseif(in_array($order->status, ['processing']))
                                    <i class="fas fa-clock fa-2x text-warning"></i>
                                @else
                                    <i class="fas fa-circle fa-2x text-muted"></i>
                                @endif
                            </div>
                            <h6>Ready for Delivery</h6>
                            <p class="text-sm">Medicines are ready</p>
                        </div>
                        <div class="col-md-3 text-center">
                            <div class="mb-3">
                                @if($order->status == 'delivered')
                                    <i class="fas fa-check-circle fa-2x text-success"></i>
                                @elseif($order->status == 'out_for_delivery')
                                    <i class="fas fa-truck fa-2x text-info"></i>
                                @else
                                    <i class="fas fa-circle fa-2x text-muted"></i>
                                @endif
                            </div>
                            <h6>Delivered</h6>
                            <p class="text-sm">Order delivered successfully</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="row">
        <div class="col-12 text-center">
            @if($order->status === 'pending')
                <form action="{{ route('administration.orders.cancel', $order->id) }}"
                      method="POST"
                      class="d-inline"
                      onsubmit="return confirm('Are you sure you want to cancel this order?')">
                    @csrf
                    <button type="submit" class="btn btn-danger btn-lg me-3">
                        <i class="fas fa-times me-2"></i>Cancel Order
                    </button>
                </form>
            @endif

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
}

.table th {
    border-top: none;
    font-weight: 600;
}

.badge {
    font-size: 0.8em;
}

.fa-check-circle {
    color: #28a745 !important;
}

.fa-clock {
    color: #ffc107 !important;
}

.fa-truck {
    color: #17a2b8 !important;
}
</style>
@endsection