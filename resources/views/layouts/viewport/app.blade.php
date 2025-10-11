<!DOCTYPE html>
<html lang="en">
<head>
    @include('layouts.viewport.partials_.metas')
    <link rel="shortcut icon" href="{{ config('app.favicon') }}" type="image/x-icon">
    <title>
        {{config('app.name')}} - @yield('viewport_title')
    </title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- Styles -->
    @include('layouts.viewport.partials_.viewport-css')
</head>
<body class="text-white min-h-screen">

    <!-- Navigation Bar -->
    @include('layouts.viewport.partials_.navigation')

    <!-- Add padding to the top of your main content to account for fixed nav -->
    <div class="pt-20"> <!-- Adjust this value based on your nav height -->
        <!-- Your page content goes here -->
    </div>

    <!-- Main Content -->
    <main class="container mx-auto px-6 py-8">
        @yield('content')
    </main>

    <!-- Footer -->
    @include('layouts.viewport.partials_.footer')

    <!-- Scripts -->
    @include('layouts.viewport.partials_.viewport-js')
</body>
</html>