$(document).ready(function() {
    // Initialize Charts
    initializeCharts();

    // Filter handling
    $('.form-select, #dateFilter').change(function() {
        filterAppointments();
    });

    $('#searchInput').on('input', debounce(function() {
        filterAppointments();
    }, 300));

    function filterAppointments() {
        const filters = {
            status: $('#statusFilter').val(),
            doctor_id: $('#doctorFilter').val(),
            date: $('#dateFilter').val(),
            search: $('#searchInput').val()
        };

        $.get('{{ route("administration.appointment.index") }}', filters, function(data) {
            $('.appointments-list').html(data);
        });
    }
});

function editAppointment(id) {
    window.location.href = '{{ route('administration.appointment.edit', ':id') }}'.replace(':id', id);
}

function deleteAppointment(id) {
    if (confirm('Are you sure you want to delete this appointment?')) {
        $.ajax({
            url: '{{ route('administration.appointment.delete', ':id') }}'.replace(':id', id),
            type: 'POST',
            data: {
                _method: 'DELETE',
                _token: '{{ csrf_token() }}'
            },
            success: function() {
                // Refresh list using current filters
                const filters = {
                    status: $('#statusFilter').val(),
                    doctor_id: $('#doctorFilter').val(),
                    date: $('#dateFilter').val(),
                    search: $('#searchInput').val()
                };
                $.get('{{ route('administration.appointment.index') }}', filters, function(data) {
                    $('.appointments-list').html(data);
                });
            }
        });
    }
}

function initializeCharts() {
    // Status Distribution Chart
    new Chart(document.getElementById('statusChart'), {
        type: 'doughnut',
        data: {
            labels: ['Pending', 'Confirmed', 'Canceled'],
            datasets: [{
                data: {{ json_encode($charts['status']) }},
                backgroundColor: ['#ffc107', '#28a745', '#dc3545']
            }]
        }
    });

    // Weekly Trend Chart
    new Chart(document.getElementById('trendChart'), {
        type: 'line',
        data: {
            labels: {!! json_encode($charts['weekly']['labels']) !!},
            datasets: [{
                label: 'Appointments',
                data: {!! json_encode($charts['weekly']['data']) !!},
                borderColor: '#4e73df',
                tension: 0.1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            }
        }
    });
}

function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}