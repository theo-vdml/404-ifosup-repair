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
        <aside id="sidebar"
            class="fixed inset-y-0 left-0 z-50 flex flex-col h-full transition-all duration-500 ease-out transform -translate-x-full border-r shadow-lg w-72 bg-white/80 backdrop-blur-xl border-slate-200/50 md:translate-x-0 md:relative md:z-auto">
            <div class="flex items-center justify-center h-20 border-b border-slate-200/50">
                <div class="flex items-center space-x-3">
                    <div
                        class="flex items-center justify-center w-8 h-8 rounded-lg bg-gradient-to-r from-indigo-500 to-purple-600">
                        <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z" />
                        </svg>
                    </div>
                    <span class="text-lg font-bold text-slate-900">Dashboard</span>
                </div>
                <button class="transition-colors md:hidden text-slate-500 hover:text-slate-700"
                    onclick="toggleSidebar()">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <nav class="flex-1 p-4 space-y-2 overflow-y-auto">
                <div>
                    <div class="px-4 py-2 text-xs font-semibold tracking-wider uppercase text-slate-500">Main</div>
                    <a href="#"
                        class="flex items-center px-4 py-3 space-x-3 transition-all duration-200 border border-transparent text-slate-700 hover:bg-purple-50/60 hover:text-slate-900 hover:border-purple-200/40 rounded-xl group">
                        <svg class="w-5 h-5 transition-colors text-slate-500 group-hover:text-purple-600" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                        <span class="font-medium">Home</span>
                    </a>
                    <a href="#"
                        class="flex items-center px-4 py-3 space-x-3 transition-all duration-200 border border-transparent text-slate-700 hover:bg-purple-50/60 hover:text-slate-900 hover:border-purple-200/40 rounded-xl group">
                        <svg class="w-5 h-5 transition-colors text-slate-500 group-hover:text-purple-600" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        <span class="font-medium">Profile</span>
                    </a>
                </div>
                <div class="pt-4 border-t border-slate-200/50">
                    <div class="px-4 py-2 text-xs font-semibold tracking-wider uppercase text-slate-500">Management
                    </div>
                    <a href="#"
                        class="flex items-center px-4 py-3 space-x-3 transition-all duration-200 border border-transparent text-slate-700 hover:bg-purple-50/60 hover:text-slate-900 hover:border-purple-200/40 rounded-xl group">
                        <svg class="w-5 h-5 transition-colors text-slate-500 group-hover:text-purple-600" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        <span class="font-medium">Settings</span>
                    </a>
                    <a href="#"
                        class="flex items-center px-4 py-3 space-x-3 transition-all duration-200 border border-transparent text-slate-700 hover:bg-purple-50/60 hover:text-slate-900 hover:border-purple-200/40 rounded-xl group">
                        <svg class="w-5 h-5 transition-colors text-slate-500 group-hover:text-purple-600" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                        <span class="font-medium">Reports</span>
                    </a>
                    <a href="#"
                        class="flex items-center px-4 py-3 space-x-3 transition-all duration-200 border border-transparent text-slate-700 hover:bg-purple-50/60 hover:text-slate-900 hover:border-purple-200/40 rounded-xl group">
                        <svg class="w-5 h-5 transition-colors text-slate-500 group-hover:text-purple-600" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 8v8m-4-5v5m-4-2v2m-2 4h12a2 2 0 002-2V8a2 2 0 00-2-2h-1.586a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 0010.586 3H8a2 2 0 00-2 2v2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                        </svg>
                        <span class="font-medium">Analytics</span>
                    </a>
                </div>
                <div class="pt-4 border-t border-slate-200/50">
                    <div class="px-4 py-2 text-xs font-semibold tracking-wider uppercase text-slate-500">Data</div>
                    <a href="#"
                        class="flex items-center px-4 py-3 space-x-3 transition-all duration-200 border border-transparent text-slate-700 hover:bg-purple-50/60 hover:text-slate-900 hover:border-purple-200/40 rounded-xl group">
                        <svg class="w-5 h-5 transition-colors text-slate-500 group-hover:text-purple-600" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        <span class="font-medium">Users</span>
                    </a>
                    <a href="#"
                        class="flex items-center px-4 py-3 space-x-3 transition-all duration-200 border border-transparent text-slate-700 hover:bg-purple-50/60 hover:text-slate-900 hover:border-purple-200/40 rounded-xl group">
                        <svg class="w-5 h-5 transition-colors text-slate-500 group-hover:text-purple-600"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 00-2-2H9a2 2 0 00-2-2z" />
                        </svg>
                        <span class="font-medium">Tickets</span>
                    </a>
                    <a href="#"
                        class="flex items-center px-4 py-3 space-x-3 transition-all duration-200 border border-transparent text-slate-700 hover:bg-purple-50/60 hover:text-slate-900 hover:border-purple-200/40 rounded-xl group">
                        <svg class="w-5 h-5 transition-colors text-slate-500 group-hover:text-purple-600"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        <span class="font-medium">Customers</span>
                    </a>
                </div>
                <div class="pt-4 border-t border-slate-200/50">
                    <div class="px-4 py-2 text-xs font-semibold tracking-wider uppercase text-slate-500">Support</div>
                    <a href="#"
                        class="flex items-center px-4 py-3 space-x-3 transition-all duration-200 border border-transparent text-slate-700 hover:bg-purple-50/60 hover:text-slate-900 hover:border-purple-200/40 rounded-xl group">
                        <svg class="w-5 h-5 transition-colors text-slate-500 group-hover:text-purple-600"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 17h5l-5 5v-5zM4.868 12.683A17.925 17.925 0 0112 21c7.962 0 12-1.21 12-2.683m-12 2.683a17.925 17.925 0 01-7.132-8.317M12 21c4.411 0 8-4.03 8-9s-3.589-9-8-9-8 4.03-8 9a9.06 9.06 9 0 001.832 5.683L4 21l4.868-8.317z" />
                        </svg>
                        <span class="font-medium">Notifications</span>
                    </a>
                    <a href="#"
                        class="flex items-center px-4 py-3 space-x-3 transition-all duration-200 border border-transparent text-slate-700 hover:bg-purple-50/60 hover:text-slate-900 hover:border-purple-200/40 rounded-xl group">
                        <svg class="w-5 h-5 transition-colors text-slate-500 group-hover:text-purple-600"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span class="font-medium">Help</span>
                    </a>
                    <a href="#"
                        class="flex items-center px-4 py-3 space-x-3 transition-all duration-200 border border-transparent text-slate-700 hover:bg-red-50/60 hover:text-red-700 hover:border-red-200/40 rounded-xl group">
                        <svg class="w-5 h-5 transition-colors text-slate-500 group-hover:text-red-600" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                        <span class="font-medium">Logout</span>
                    </a>
                </div>
            </nav>
            <div class="p-4 border-t border-slate-200/50">
                <div class="flex items-center space-x-3">
                    <div
                        class="flex items-center justify-center w-10 h-10 font-semibold text-white rounded-full bg-gradient-to-r from-indigo-500 to-purple-600">
                        U</div>
                    <div>
                        <p class="text-sm font-medium text-slate-900">User</p>
                        <p class="text-xs text-slate-500">user@example.com</p>
                    </div>
                </div>
            </div>
        </aside>

        <!-- Overlay for mobile -->
        <div id="sidebar-overlay" class="fixed inset-0 z-40 hidden bg-black/20 backdrop-blur-sm md:hidden"
            onclick="toggleSidebar()"></div>

        <!-- Main content -->
        <div class="flex flex-col flex-1">
            <!-- Header -->
            <header class="sticky top-0 z-30 h-20 bg-white border-b border-slate-200/50">
                <div class="h-full px-4 mx-auto max-w-7xl md:px-6">
                    <div class="flex items-center justify-between h-full md:justify-center">
                        <!-- Burger on mobile -->
                        <button
                            class="p-2 transition-all duration-200 md:hidden text-slate-700 hover:bg-slate-100 rounded-xl"
                            onclick="toggleSidebar()">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                        </button>
                        <!-- Desktop search -->
                        <div class="relative hidden w-full max-w-md md:block">
                            <input type="text" placeholder="Search..."
                                class="w-full py-2 pl-10 pr-16 transition-all duration-200 border bg-slate-50 border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                            <svg class="absolute left-3 top-2.5 w-5 h-5 text-slate-400" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                            <span
                                class="absolute right-3 top-2.5 text-xs text-slate-400 bg-slate-100 px-1.5 py-0.5 rounded">Ctrl+K</span>
                        </div>
                        <!-- Mobile search button -->
                        <button
                            class="p-2 transition-all duration-200 md:hidden text-slate-700 hover:bg-slate-100 rounded-xl">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </button>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1 p-8 overflow-y-auto bg-gradient-to-br from-slate-50 to-white">
                <div class="mx-auto max-w-7xl">
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
