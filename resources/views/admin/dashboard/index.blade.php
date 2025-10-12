@extends('layouts.administration.app')

@section('admin_title_content')
    {{config('app.name')}} || Dashboard
@endsection

@section('admin_content_header')
    <div class="col-sm-6">
        <h1 class="m-0">
            @if(auth()->user()->hasRole('Patient'))
                <i class="fas fa-user-circle me-2"></i>Patient Dashboard
            @elseif(auth()->user()->hasRole('Doctor'))
                <i class="fas fa-user-md me-2"></i>Doctor Dashboard
            @else
                <i class="fas fa-crown me-2"></i>Admin Dashboard
            @endif
        </h1>
    </div><!-- /.col -->
    <!-- breadcrumb -->
    <x-ad-breadcrumb :items="[
        ['label' => 'Dashboard'],
    ]" />
@endsection

@section('admin_vendor_css')
@endsection

@section('admin_page_css')
<style>
    .dashboard-card {
        transition: all 0.3s ease;
        border: none;
        border-radius: 15px;
        overflow: hidden;
    }
    .dashboard-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.15);
    }
    .gradient-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }
    .gradient-success {
        background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
    }
    .gradient-info {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }
    .gradient-warning {
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
    }
    .gradient-danger {
        background: linear-gradient(135deg, #ff6b6b 0%, #ee5a52 100%);
    }
    .stat-icon {
        font-size: 2.5rem;
        opacity: 0.8;
    }
    .welcome-banner {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border-radius: 15px;
        padding: 2rem;
        margin-bottom: 2rem;
    }
    .activity-item {
        background: #f8f9fa;
        border-left: 4px solid var(--bs-primary);
        padding: 1rem;
        margin-bottom: 1rem;
        border-radius: 8px;
    }
    .appointment-card {
        background: #fff;
        border: 1px solid #e9ecef;
        border-radius: 10px;
        padding: 1.5rem;
        margin-bottom: 1rem;
        transition: all 0.3s ease;
    }
    .appointment-card:hover {
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        transform: translateY(-2px);
    }
    .prescription-card {
        background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
        color: white;
        border-radius: 10px;
        padding: 1rem;
        margin-bottom: 1rem;
    }
    .quick-action-btn {
        border-radius: 50%;
        width: 50px;
        height: 50px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        margin: 0.25rem;
        transition: all 0.3s ease;
    }
    .quick-action-btn:hover {
        transform: scale(1.1);
    }
</style>
@endsection

@section('main_content')
    <div class="container-fluid">
        <!-- Welcome Banner -->
        <div class="welcome-banner">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h2 class="mb-2">
                        Welcome back, {{ auth()->user()->name }}!
                        @if(auth()->user()->hasRole('Patient'))
                            <i class="fas fa-user-circle ms-2"></i>
                        @elseif(auth()->user()->hasRole('Doctor'))
                            <i class="fas fa-user-md ms-2"></i>
                        @else
                            <i class="fas fa-crown ms-2"></i>
                        @endif
                    </h2>
                    <p class="mb-0 opacity-75">
                        {{ now()->format('l, F j, Y') }} • {{ now()->format('g:i A') }}
                    </p>
                </div>
                <div class="col-md-4 text-md-end">
                    <div class="d-flex align-items-center justify-content-end">
                        <div class="weather-info me-3">
                            <i class="fas fa-cloud-sun fa-2x opacity-75"></i>
                        </div>
                        <div>
                            <h4 class="mb-0">{{ now()->format('H:i') }}</h4>
                            <small class="opacity-75">{{ now()->format('A') }}</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if(auth()->user()->hasRole('Super Admin'))
            {{-- Admin Dashboard --}}
            @include('admin.dashboard.partials.admin_dashboard')
        @elseif(auth()->user()->hasRole('Doctor'))
            {{-- Doctor Dashboard --}}
            @include('admin.dashboard.partials.doctor_dashboard')
        @elseif(auth()->user()->hasRole('Patient'))
            {{-- Patient Dashboard --}}
            @include('admin.dashboard.partials.patient_dashboard')
        @endif

        <!-- Recent Activities (All Roles) -->
        <div class="row mt-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-clock me-2"></i>
                            Recent Activities
                        </h5>
                    </div>
                    <div class="card-body">
                        @php
                            $activities = auth()->user()->activities()->latest()->limit(5)->get();
                        @endphp

                        @forelse($activities as $activity)
                            <div class="activity-item">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div class="flex-grow-1">
                                        <p class="mb-1">{{ $activity->description }}</p>
                                        <small class="text-muted">
                                            <i class="fas fa-calendar me-1"></i>
                                            {{ $activity->created_at->diffForHumans() }}
                                        </small>
                                    </div>
                                    <span class="badge bg-info">{{ $activity->event }}</span>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-4">
                                <i class="fas fa-inbox text-muted mb-3" style="font-size: 2rem;"></i>
                                <p class="text-muted mb-0">No recent activities found</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div><!-- /.container-fluid -->
@endsection

@section('admin_vendor_js')
    <script src="{{ asset('assets/plugins/chart.js/Chart.bundle.min.js') }}"></script>
@endsection

@section('admin_page_js')
<script>
    $(document).ready(function() {
        // Animate counters
        $('.stat-number').each(function() {
            const $this = $(this);
            const countTo = $this.attr('data-count');

            $({ countNum: 0 }).animate({
                countNum: countTo
            }, {
                duration: 2000,
                easing: 'swing',
                step: function() {
                    $this.text(Math.floor(this.countNum));
                },
                complete: function() {
                    $this.text(countTo);
                }
            });
        });

        // Auto refresh dashboard data every 5 minutes
        setInterval(function() {
            if (!$('body').hasClass('refreshing')) {
                $('body').addClass('refreshing');
                location.reload();
            }
        }, 300000);
    });
</script>
@endsection
