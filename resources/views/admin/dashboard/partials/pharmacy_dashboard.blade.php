<!-- Pharmacy Dashboard Content -->
<div class="row">
    <!-- Pharmacy Statistics -->
    <div class="col-lg-4 col-6">
        <div class="dashboard-card card gradient-success text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="card-title">Total Orders</h6>
                        <h2 class="mb-0 stat-number" data-count="{{ \App\Models\MedicineOrder\MedicineOrder::where('pharmacy_id', auth()->user()->pharmacy->id)->count() }}">
                            {{ \App\Models\MedicineOrder\MedicineOrder::where('pharmacy_id', auth()->user()->pharmacy->id)->count() }}
                        </h2>
                        <small>All orders</small>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-shopping-cart stat-icon"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4 col-6">
        <div class="dashboard-card card gradient-primary text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="card-title">Pending Orders</h6>
                        <h2 class="mb-0 stat-number" data-count="{{ \App\Models\MedicineOrder\MedicineOrder::where('pharmacy_id', auth()->user()->pharmacy->id)->where('status', 'pending')->count() }}">
                            {{ \App\Models\MedicineOrder\MedicineOrder::where('pharmacy_id', auth()->user()->pharmacy->id)->where('status', 'pending')->count() }}
                        </h2>
                        <small>Awaiting processing</small>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-clock stat-icon"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4 col-6">
        <div class="dashboard-card card gradient-info text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="card-title">Completed Today</h6>
                        <h2 class="mb-0 stat-number" data-count="{{ \App\Models\MedicineOrder\MedicineOrder::where('pharmacy_id', auth()->user()->pharmacy->id)->where('status', 'completed')->whereDate('updated_at', today())->count() }}">
                            {{ \App\Models\MedicineOrder\MedicineOrder::where('pharmacy_id', auth()->user()->pharmacy->id)->where('status', 'completed')->whereDate('updated_at', today())->count() }}
                        </h2>
                        <small>Orders completed</small>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-check-circle stat-icon"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<!-- Recent Orders and Quick Actions -->
<div class="row mt-4">
    <!-- Recent Orders -->
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-list me-2"></i>
                    Recent Orders
                </h5>
            </div>
            <div class="card-body">
                @php
                    $recentOrders = \App\Models\MedicineOrder\MedicineOrder::with(['patient.profile'])
                        ->where('pharmacy_id', auth()->user()->pharmacy->id)
                        ->latest()->limit(5)->get();
                @endphp

                @forelse($recentOrders as $order)
                    <div class="appointment-card">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="flex-grow-1">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0 me-3">
                                        <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                            {{ strtoupper(substr($order->patient->name ?? 'U', 0, 1)) }}
                                        </div>
                                    </div>
                                    <div>
                                        <h6 class="mb-1">{{ $order->patient->name ?? 'Unknown Patient' }}</h6>
                                        <p class="mb-1 text-muted">{{ $order->created_at->format('M d, Y h:i A') }}</p>
                                        @if($order->prescription)
                                            <small class="text-muted">{{ $order->prescription->items->count() ?? 0 }} items • Status: {{ ucfirst($order->status) }}</small>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="text-end">
                                <span class="badge bg-{{ $order->status === 'completed' ? 'success' : ($order->status === 'pending' ? 'warning' : 'secondary') }} mb-2">
                                    {{ ucfirst($order->status) }}
                                </span>
                                <br>
                                <a href="{{ route('administration.orders.pharmacy.show', $order->id) }}" class="btn btn-info btn-sm">
                                    <i class="fas fa-eye me-1"></i>View
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-4">
                        <i class="fas fa-shopping-cart text-muted mb-3" style="font-size: 3rem;"></i>
                        <h5 class="text-muted">No orders yet</h5>
                        <p class="text-muted">Orders will appear here once patients place them.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Quick Actions & Profile -->
    <div class="col-lg-4">
        <!-- Quick Actions -->
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-bolt me-2"></i>
                    Quick Actions
                </h5>
            </div>
            <div class="card-body">
                <div class="d-flex flex-column">
                    <a href="{{ route('administration.orders.pharmacy.index') }}" class="btn btn-primary mb-3">
                        <i class="fas fa-list me-2"></i>View All Orders
                    </a>
                    
                    <a href="{{ route('profile.edit') }}" class="btn btn-info">
                        <i class="fas fa-user-edit me-2"></i>Update Profile
                    </a>
                </div>
            </div>
        </div>

        <!-- Pharmacy Profile Summary -->
        <div class="card mt-3">
            <div class="card-header">
                <h6 class="card-title mb-0">
                    <i class="fas fa-pills me-2"></i>
                    My Pharmacy
                </h6>
            </div>
            <div class="card-body text-center">
                @php
                    $pharmacy = auth()->user()->pharmacy;
                @endphp
                @if($pharmacy)
                    <div class="mb-3">
                        <h5 class="mb-1">{{ $pharmacy->name ?? 'Pharmacy' }}</h5>
                        <p class="text-muted mb-2">{{ $pharmacy->address ?? 'Address not set' }}</p>
                        @if($pharmacy->license_number)
                            <span class="badge bg-info">License: {{ $pharmacy->license_number }}</span>
                        @endif
                    </div>
                    <div class="d-grid gap-2">
                        <a href="{{ route('profile.edit') }}" class="btn btn-outline-primary btn-sm">
                            <i class="fas fa-edit me-1"></i>Edit Profile
                        </a>
                    </div>
                @else
                    <div class="text-center py-3">
                        <i class="fas fa-pills text-muted mb-2" style="font-size: 2rem;"></i>
                        <p class="text-muted mb-0">Complete your pharmacy profile</p>
                        <a href="{{ route('profile.edit') }}" class="btn btn-primary btn-sm mt-2">
                            Setup Profile
                        </a>
                    </div>
                @endif
            </div>
        </div>

        <!-- Today's Summary -->
        <div class="card mt-3">
            <div class="card-header">
                <h6 class="card-title mb-0">
                    <i class="fas fa-calendar-day me-2"></i>
                    Today's Summary
                </h6>
            </div>
            <div class="card-body">
                @php
                    $todayOrders = \App\Models\MedicineOrder\MedicineOrder::where('pharmacy_id', auth()->user()->pharmacy->id)
                        ->whereDate('created_at', today())
                        ->count();
                @endphp
                <div class="text-center">
                    <h3 class="text-primary mb-1">{{ $todayOrders }}</h3>
                    <p class="text-muted mb-0">Orders received today</p>
                </div>
            </div>
        </div>
    </div>
</div>
