<div class="appointments-list">
    @forelse($appointments as $appointment)
        <x-appointment-card :appointment="$appointment" />
    @empty
        <div class="text-center py-4">
            <i class="fas fa-calendar-times text-muted mb-3" style="font-size: 2rem;"></i>
            <p class="text-muted mb-0">No appointments found</p>
        </div>
    @endforelse
</div>

<div class="d-flex justify-content-center mt-3">
    {{ $appointments->links() }}
</div>