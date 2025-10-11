<!-- AOS Library -->
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
@section('viewport_vendor_js')
    @show
<script>
    AOS.init({
        duration: 800,
        once: true,
        offset: 50
    });
    
    // Refresh animation for data updates
    function triggerDataRefresh() {
        document.querySelectorAll('.refresh-pulse').forEach(element => {
            element.classList.add('data-refresh');
            setTimeout(() => {
                element.classList.remove('data-refresh');
            }, 2000);
        });
    }
    
    // Auto refresh every 10 seconds
    setInterval(triggerDataRefresh, 10000);
    
    // Simulate live data updates
    setInterval(() => {
        const healthScore = document.getElementById('healthScore');
        if(healthScore) {
            healthScore.classList.add('data-refresh');
            setTimeout(() => {
                healthScore.classList.remove('data-refresh');
            }, 1000);
        }
    }, 8000);
    
    // Navigation active state
    document.querySelectorAll('.nav-link').forEach(link => {
        link.addEventListener('click', function() {
            document.querySelectorAll('.nav-link').forEach(l => l.classList.remove('active'));
            this.classList.add('active');
        });
    });
</script>

@section('viewport_page_js')
    @show