<header class="sticky top-0 z-30 h-20 bg-white border-b border-slate-200/50">
    <div class="h-full px-4 mx-auto max-w-7xl md:px-6">
        <div class="flex items-center justify-between h-full md:justify-center">
            <!-- Burger on mobile -->
            <button class="p-2 transition-all duration-200 md:hidden text-slate-700 hover:bg-slate-100 rounded-xl"
                onclick="toggleSidebar()">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
            <!-- Desktop search -->
            <div class="relative hidden w-full max-w-md md:block">
                <input type="text" placeholder="Search..."
                    class="w-full py-2 pl-10 pr-16 transition-all duration-200 border bg-slate-50 border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                <svg class="absolute left-3 top-2.5 w-5 h-5 text-slate-400" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
                <span
                    class="absolute right-3 top-2.5 text-xs text-slate-400 bg-slate-100 px-1.5 py-0.5 rounded">Ctrl+K</span>
            </div>
            <!-- Mobile search button -->
            <button class="p-2 transition-all duration-200 md:hidden text-slate-700 hover:bg-slate-100 rounded-xl">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </button>
        </div>
    </div>
</header>
