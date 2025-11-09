<div class="bg-white border rounded-lg border-slate-300/50">
    <div class="p-5 border-b rounded-t-lg border-slate-200 bg-gradient-to-r from-slate-50 to-white">
        <h3 class="flex items-center gap-2 font-semibold text-slate-900">
            <x-heroicon-o-cog-6-tooth class="w-5 h-5 text-slate-600" />
            Détails du ticket
        </h3>
    </div>

    <form action="{{ route('tickets.update', $ticket) }}" method="POST" class="p-5">
        @csrf
        @method('PATCH')

        <div class="space-y-4">
            <!-- Priority -->
            <div>
                <label for="priority_id" class="block mb-2 text-xs font-medium tracking-wider uppercase text-slate-700">
                    Priorité
                </label>
                <div class="relative">
                    <select id="priority_id" name="priority_id"
                        class="w-full px-3 py-2.5 text-sm border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white transition-all appearance-none cursor-pointer hover:border-slate-400">
                        @foreach ($priorities as $priority)
                            <option value="{{ $priority->id }}"
                                {{ $ticket->priority_id === $priority->id ? 'selected' : '' }}>
                                {{ $priority->label ?? $priority->code }}
                            </option>
                        @endforeach
                    </select>
                    <div class="absolute inset-y-0 right-0 flex items-center px-3 pointer-events-none text-slate-600">
                        <x-heroicon-o-chevron-down class="w-4 h-4" />
                    </div>
                </div>
            </div>

            <!-- Status -->
            <div>
                <label for="status_id" class="block mb-2 text-xs font-medium tracking-wider uppercase text-slate-700">
                    Statut
                </label>
                <div class="relative">
                    <select id="status_id" name="status_id"
                        class="w-full px-3 py-2.5 text-sm border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white transition-all appearance-none cursor-pointer hover:border-slate-400">
                        @foreach ($statuses as $status)
                            <option value="{{ $status->id }}"
                                {{ $ticket->status_id === $status->id ? 'selected' : '' }}>
                                {{ $status->label ?? $status->code }}
                            </option>
                        @endforeach
                    </select>
                    <div class="absolute inset-y-0 right-0 flex items-center px-3 pointer-events-none text-slate-600">
                        <x-heroicon-o-chevron-down class="w-4 h-4" />
                    </div>
                </div>
            </div>

            <!-- Update Button -->
            <div class="pt-2">
                <button type="submit"
                    class="w-full inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors shadow-sm">
                    <x-heroicon-o-check class="w-4 h-4" />
                    Mettre à jour
                </button>
            </div>

            <!-- Metadata -->
            <div class="pt-4 border-t border-slate-200">
                <div class="space-y-3">
                    <div class="flex items-center justify-between">
                        <span class="text-xs text-slate-500 flex items-center gap-1.5">
                            <x-heroicon-o-calendar class="w-3.5 h-3.5" />
                            Créé le
                        </span>
                        <span
                            class="text-xs font-medium text-slate-900">{{ $ticket->created_at->format('d/m/Y H:i') }}</span>
                    </div>

                    <div class="flex items-center justify-between">
                        <span class="text-xs text-slate-500 flex items-center gap-1.5">
                            <x-heroicon-o-arrow-path class="w-3.5 h-3.5" />
                            Dernière MAJ
                        </span>
                        <span
                            class="text-xs font-medium text-slate-900">{{ $ticket->updated_at->diffForHumans() }}</span>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
