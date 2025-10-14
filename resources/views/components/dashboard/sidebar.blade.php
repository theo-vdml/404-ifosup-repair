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
         <button class="transition-colors md:hidden text-slate-500 hover:text-slate-700" onclick="toggleSidebar()">
             <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                 <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
             </svg>
         </button>
     </div>
     <nav class="flex-1 p-4 space-y-2 overflow-y-auto">
         <div>
             <div class="px-4 py-2 text-xs font-semibold tracking-wider uppercase text-slate-500">Main</div>

             <x-dashboard.nav-link label="Home" href="#">
                 <x-slot name="icon">
                     <x-heroicon-o-home class="w-5 h-5" />
                 </x-slot>
             </x-dashboard.nav-link>
         </div>
         <div class="pt-4 border-t border-slate-200/50">
             <div class="px-4 py-2 text-xs font-semibold tracking-wider uppercase text-slate-500">Admin</div>

             <x-dashboard.nav-link label="Inbox" href="#">
                 <x-slot name="icon">
                     <x-heroicon-o-inbox class="w-5 h-5" />
                 </x-slot>
             </x-dashboard.nav-link>
         </div>
         <div class="pt-4 border-t border-slate-200/50">
             <div class="px-4 py-2 text-xs font-semibold tracking-wider uppercase text-slate-500">Interventions
             </div>
             <x-dashboard.nav-link label="Tickets" href="#">
                 <x-slot name="icon">
                     <x-heroicon-o-rectangle-stack class="w-5 h-5" />
                 </x-slot>
             </x-dashboard.nav-link>
             <x-dashboard.nav-link label="Mes Tickets" href="#">
                 <x-slot name="icon">
                     <x-heroicon-o-ticket class="w-5 h-5" />
                 </x-slot>
             </x-dashboard.nav-link>
         </div>
         <div class="pt-4 border-t border-slate-200/50">
             <div class="px-4 py-2 text-xs font-semibold tracking-wider uppercase text-slate-500">Contacts</div>
             <x-dashboard.nav-link label="Clients" href="{{ route('customers.index') }}">
                 <x-slot name="icon">
                     <x-heroicon-o-users class="w-5 h-5" />
                 </x-slot>
             </x-dashboard.nav-link>
             <x-dashboard.nav-link label="Techniciens" href="#">
                 <x-slot name="icon">
                     <x-heroicon-o-wrench-screwdriver class="w-5 h-5" />
                 </x-slot>
             </x-dashboard.nav-link>
         </div>
         <div class="pt-4 border-t border-slate-200/50">
             <div class="px-4 py-2 text-xs font-semibold tracking-wider uppercase text-slate-500">Ressources</div>
             <x-dashboard.nav-link label="Documentation" href="#">
                 <x-slot name="icon">
                     <x-heroicon-o-book-open class="w-5 h-5" />
                 </x-slot>
             </x-dashboard.nav-link>
             <x-dashboard.nav-link label="FAQ" href="#">
                 <x-slot name="icon">
                     <x-heroicon-o-chat-bubble-left-right class="w-5 h-5" />
                 </x-slot>
             </x-dashboard.nav-link>
         </div>
         <div class="pt-4 border-t border-slate-200/50">
             <div class="px-4 py-2 text-xs font-semibold tracking-wider uppercase text-slate-500">Configuration</div>
             <x-dashboard.nav-link label="Paramètres" href="#">
                 <x-slot name="icon">
                     <x-heroicon-o-adjustments-horizontal class="w-5 h-5" />
                 </x-slot>
             </x-dashboard.nav-link>
             <x-dashboard.nav-link label="Mon Profil" href="#">
                 <x-slot name="icon">
                     <x-heroicon-o-user class="w-5 h-5" />
                 </x-slot>
             </x-dashboard.nav-link>
             <x-dashboard.nav-link label="Déconnexion" href="#">
                 <x-slot name="icon">
                     <x-heroicon-o-arrow-right-on-rectangle class="w-5 h-5" />
                 </x-slot>
             </x-dashboard.nav-link>
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
