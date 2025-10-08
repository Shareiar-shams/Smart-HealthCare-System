@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h2 class="mb-4">Find a Doctor</h2>
    <div class="row">
        @foreach($doctors as $doctor)
            <div class="col-md-4 mb-3">
                <div class="card h-100">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">Dr. {{ $doctor->user->name ?? 'N/A' }}</h5>
                        <p class="mb-1"><strong>Specialization:</strong> {{ $doctor->specialization }}</p>
                        <p class="mb-2"><strong>Hospital:</strong> {{ $doctor->hospital_name }}</p>
                        <a href="{{ route('appointments.doctor', $doctor) }}" class="mt-auto btn btn-primary">View & Book</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    {{ $doctors->links() }}
</div>
@endsection
