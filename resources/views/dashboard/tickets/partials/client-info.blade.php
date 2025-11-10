<div class="bg-white border rounded-lg border-slate-300/50">
    <div class="p-5 border-b rounded-t-lg border-slate-200 bg-gradient-to-r from-slate-50 to-white">
        <h3 class="flex items-center gap-2 font-semibold text-slate-900">
            <x-heroicon-o-user-circle class="w-5 h-5 text-slate-600" />
            Informations client
        </h3>
    </div>

    <div class="p-5">
        <!-- Customer Info -->
        <div class="mb-4 space-y-3">
            <div class="flex items-center gap-3">
                <div class="flex items-center justify-center flex-shrink-0 w-8 h-8 rounded-full bg-slate-100">
                    <x-heroicon-o-user class="w-4 h-4 text-slate-600" />
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-blue-600">{{ $ticket->customer->full_name }}</p>
                    <p class="text-xs text-slate-600">{{ $ticket->customer->email }}</p>
                </div>
            </div>
        </div>

        <!-- View Profile Button -->
        <a href="{{ route('customers.show', $ticket->customer) }}"
            class="inline-flex items-center justify-center w-full gap-2 px-3 py-2 text-sm transition-colors border rounded-md text-slate-600 border-slate-300 hover:bg-slate-50">
            <x-heroicon-o-eye class="w-4 h-4" />
            Voir le profil
        </a>
    </div>
</div>
