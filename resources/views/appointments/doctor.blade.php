@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <h3>Dr. {{ $doctor->user->name ?? 'N/A' }}</h3>
                    <p><strong>Specialization:</strong> {{ $doctor->specialization }}</p>
                    <p><strong>Hospital:</strong> {{ $doctor->hospital_name }}</p>
                    <p><strong>Chamber:</strong> {{ $doctor->chamber_address }}</p>
                    <p><strong>Available:</strong> {{ $doctor->available_days }} - {{ $doctor->available_time }}</p>
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-body">
                    <h4>Book Appointment</h4>
                    @guest
                        <p>Please <a href="{{ route('login') }}">login</a> to book an appointment.</p>
                    @else
                        <form method="post" action="{{ route('appointments.book', $doctor) }}">
                            @csrf
                            <div class="mb-3">
                                <label for="date">Date</label>
                                <input type="date" name="date" id="date" class="form-control" value="{{ old('date') }}" required />
                                @error('date')<small class="text-danger">{{ $message }}</small>@enderror
                            </div>
                            <div class="mb-3">
                                <label for="time">Time</label>
                                <input type="time" name="time" id="time" class="form-control" value="{{ old('time') }}" required />
                                @error('time')<small class="text-danger">{{ $message }}</small>@enderror
                            </div>
                            <div class="mb-3">
                                <label for="notes">Notes (optional)</label>
                                <textarea name="notes" id="notes" class="form-control">{{ old('notes') }}</textarea>
                            </div>
                            <button class="btn btn-primary">Request Appointment</button>
                        </form>
                    @endguest
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5>Doctor Info</h5>
                    <p><strong>Registration No:</strong> {{ $doctor->registration_no }}</p>
                    <p><strong>Contact:</strong> {{ $doctor->user->profile->contact_no ?? '-' }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
