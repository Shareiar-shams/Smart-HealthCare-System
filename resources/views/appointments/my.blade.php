@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h2 class="mb-4">My Appointments</h2>
    @if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
    <div class="card">
        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th>Doctor</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Status</th>
                        <th>Notes</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($appointments as $a)
                        <tr>
                            <td>{{ $a->doctor->user->name ?? 'N/A' }}</td>
                            <td>{{ 
                                
                                \Illuminate\Support\Carbon::parse($a->date)->format('Y-m-d')
                            }}</td>
                            <td>{{ $a->time }}</td>
                            <td>{{ ucfirst($a->status) }}</td>
                            <td>{{ \Illuminate\Support\Str::limit($a->notes, 60) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            {{ $appointments->links() }}
        </div>
    </div>
</div>
@endsection
