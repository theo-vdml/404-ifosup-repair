<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen font-sans antialiased bg-gradient-to-br from-slate-50 to-white">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <x-dashboard.sidebar />

        <!-- Main content -->
        <div class="flex flex-col flex-1 min-w-0">
            <!-- Header -->
            <x-dashboard.header />

            <!-- Page Content -->
            <main class="flex-1 min-w-0 p-4 overflow-auto md:p-6 lg:p-8 bg-gradient-to-br from-slate-50 to-white">
                <div class="min-w-0 mx-auto max-w-7xl">
                    {{ $slot }}
                </div>
            </main>
        </div>
    </div>

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebar-overlay');
            sidebar.classList.toggle('-translate-x-full');
            overlay.classList.toggle('hidden');
        }
    </script>
</body>

</html>
