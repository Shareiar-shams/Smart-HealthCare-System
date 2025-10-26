@extends('layouts.administration.app')

@section('title_content')
    {{config('app.name')}} || My Medicine Orders
@endsection

@section('content_header')
    <div class="col-sm-6">
        <h1 class="m-0">My Medicine Orders</h1>
    </div>
    <x-ad-breadcrumb :items="[
        ['label' => 'Dashboard', 'url' => route('dashboard')],
        ['label' => 'My Orders']
    ]" />
@endsection
@section('admin_page_css')
    <style>
        .table th {
            border-top: none;
            font-weight: 600;
        }

        .badge {
            font-size: 0.8em;
        }

        .btn-group .btn {
            margin-right: 2px;
        }
    </style>
@endsection
@section('main_content')
    <div class="container-fluid">
        <!-- Orders List -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h4 class="card-title mb-0">
                            <i class="fas fa-shopping-bag me-2"></i>
                            Order History
                        </h4>
                    </div>
                    <div class="card-body">
                        @if($orders->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Order ID</th>
                                            <th>Date</th>
                                            <th>Pharmacy</th>
                                            <th>Status</th>
                                            <th>Payment Status</th>
                                            <th>Total Amount</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($orders as $order)
                                            <tr>
                                                <td>
                                                    <strong>#{{ $order->id }}</strong>
                                                    <br>
                                                    <small class="text-muted">Prescription #{{ $order->prescription_id }}</small>
                                                </td>
                                                <td>{{ $order->created_at->format('M d, Y') }}</td>
                                                <td>{{ $order->pharmacy->pharmacy_name ?? 'N/A' }}</td>
                                                <td>
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
                                                    <span class="badge bg-{{ $statusColor }}">{{ ucfirst($order->status) }}</span>
                                                </td>
                                                <td>
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
                                                </td>
                                                <td>
                                                    <strong>${{ number_format($order->total_price, 2) }}</strong>
                                                </td>
                                                <td>
                                                    <div class="btn-group" role="group">
                                                        <a href="{{ route('administration.orders.show', $order->id) }}"
                                                        class="btn btn-sm btn-outline-primary"
                                                        title="View Details">
                                                            <i class="fas fa-eye"></i>
                                                        </a>
                                                        @if($order->status === 'pending')
                                                            <form action="{{ route('administration.orders.cancel', $order->id) }}"
                                                                method="POST"
                                                                class="d-inline"
                                                                onsubmit="return confirm('Are you sure you want to cancel this order?')">
                                                                @csrf
                                                                <button type="submit"
                                                                        class="btn btn-sm btn-outline-danger"
                                                                        title="Cancel Order">
                                                                    <i class="fas fa-times"></i>
                                                                </button>
                                                            </form>
                                                        @endif
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <!-- Pagination -->
                            <div class="d-flex justify-content-center">
                                {{ $orders->links() }}
                            </div>
                        @else
                            <div class="text-center py-5">
                                <i class="fas fa-shopping-bag fa-3x text-muted mb-3"></i>
                                <h5 class="text-muted">No Orders Found</h5>
                                <p class="text-muted">You haven't placed any medicine orders yet.</p>
                                <a href="{{ route('dashboard') }}" class="btn btn-primary">
                                    <i class="fas fa-arrow-left me-2"></i>Back to Dashboard
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Order Status Legend -->
        {{-- <div class="row mt-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-light">
                        <h6 class="card-title mb-0">
                            <i class="fas fa-info-circle me-2"></i>
                            Order Status Information
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3 text-center">
                                <span class="badge bg-warning">Pending</span>
                                <p class="text-sm mt-1">Order received and being processed</p>
                            </div>
                            <div class="col-md-3 text-center">
                                <span class="badge bg-info">Processing</span>
                                <p class="text-sm mt-1">Pharmacy is preparing your medicines</p>
                            </div>
                            <div class="col-md-3 text-center">
                                <span class="badge bg-primary">Ready</span>
                                <p class="text-sm mt-1">Medicines are ready for pickup/delivery</p>
                            </div>
                            <div class="col-md-3 text-center">
                                <span class="badge bg-success">Delivered</span>
                                <p class="text-sm mt-1">Order has been delivered successfully</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> --}}
    </div>
@endsection

