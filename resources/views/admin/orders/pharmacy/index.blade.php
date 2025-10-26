@extends('layouts.administration.app')
@section('title_content')
    {{config('app.name')}} || Pharmacy Orders
@endsection
@section('content_header')
    <div class="col-sm-6">
        <h1 class="m-0">Pharmacy Orders</h1>
    </div><!-- /.col -->
    <!-- breadcrumb -->
    <x-ad-breadcrumb :items="[
        ['label' => 'Dashboard', 'url' => route('dashboard')],
        ['label' => 'Pharmacy Orders', 'url' => route('administration.orders.pharmacy.index')],
        ['label' => 'Manage'],
    ]" />
@endsection

@section('admin_vendor_css')
    @include('admin.additionalObject.datatable-css')
@endsection
@section('admin_page_css')
@endsection

@section('main_content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">All Orders for My Pharmacy</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Serial</th>
                                    <th>Order ID</th>
                                    <th>Patient</th>
                                    <th>Prescription</th>
                                    <th>Status</th>
                                    <th>Total Price</th>
                                    <th>Ordered At</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($orders as $key => $order)
                                    <tr>
                                        <th>{{ serial($order, $key) }}</th>
                                        <td>#{{ $order->id }}</td>
                                        <td>{{ $order->patient->name ?? 'N/A' }}</td>
                                        <td>
                                            @if($order->prescription)
                                                <a href="{{ route('administration.prescriptions.show', $order->prescription->appointment_id) }}" class="btn btn-sm btn-outline-primary">
                                                    View Prescription
                                                </a>
                                            @else
                                                N/A
                                            @endif
                                        </td>
                                        <td>
                                            @can('Medicine Order Update')
                                                <button type="button" class="btn btn-sm btn-warning" data-toggle="modal" data-target="#statusModal" data-order-id="{{ $order->id }}" data-current-status="{{ $order->status }}">
                                                    <i class="fas fa-edit"></i> Update Status
                                                </button>
                                            @else
                                                <span class="badge bg-{{ $order->status === 'delivered' ? 'success' : ($order->status === 'pending' ? 'warning' : 'info') }}">
                                                    {{ ucfirst($order->status) }}
                                                </span>
                                            @endcan
                                        </td>
                                        <td>${{ number_format($order->total_price, 2) }}</td>
                                        <td>{{ $order->ordered_at ? \Carbon\Carbon::parse($order->ordered_at)->format('Y-m-d h:i A') : 'N/A' }}</td>
                                        <td>
                                            @can('Medicine Order Read')
                                                <a class="btn btn-sm btn-primary" href="{{ route('administration.orders.pharmacy.show', $order->id) }}">
                                                    <i class="fas fa-eye"></i> View Details
                                                </a>
                                            @endcan
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center">No orders found for your pharmacy.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                    @if($orders->hasPages())
                        <div class="card-footer">
                            <div class="d-flex justify-content-center">
                                {{ $orders->links() }}
                            </div>
                        </div>
                    @endif
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->

    <!-- Status Update Modal -->
    <div class="modal fade" id="statusModal" tabindex="-1" role="dialog" aria-labelledby="statusModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="statusModalLabel">Update Order Status</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="statusForm" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="statusSelect">Status</label>
                            <select name="status" id="statusSelect" class="form-control" required>
                                <option value="processing">Processing</option>
                                <option value="ready">Ready</option>
                                <option value="out_for_delivery">Out for Delivery</option>
                                <option value="delivered">Delivered</option>
                                <option value="cancelled">Cancelled</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="notesInput">Notes (Optional)</label>
                            <textarea name="notes" id="notesInput" class="form-control" rows="3" placeholder="Add any additional notes..."></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Update Status</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('admin_vendor_js')
@endsection

@section('admin_page_js')
    @include('admin.additionalObject.datatable-js')
    <script>
    $(document).ready(function() {
        $('#statusModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget); // Button that triggered the modal
            var orderId = button.data('order-id'); // Extract info from data-* attributes
            var currentStatus = button.data('current-status');

            var modal = $(this);
            modal.find('#statusForm').attr('action', '{{ url("orders/update-status") }}/' + orderId);
            modal.find('#statusSelect').val(currentStatus);
            modal.find('#notesInput').val(''); // Clear notes
        });
    });
    </script>
@endsection