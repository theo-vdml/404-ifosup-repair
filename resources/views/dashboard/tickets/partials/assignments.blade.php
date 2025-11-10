<div class="bg-white border rounded-lg border-slate-300/50">
    <div class="p-5 border-b rounded-t-lg border-slate-200 bg-gradient-to-r from-slate-50 to-white">
        <h3 class="flex items-center gap-2 font-semibold text-slate-900">
            <x-heroicon-o-users class="w-5 h-5 text-slate-600" />
            Assignés
        </h3>
    </div>

    <div class="p-5">
        <div class="mb-4 space-y-3">
            @forelse ($ticket->users as $user)
                <div class="flex items-center gap-3">
                    <div class="flex items-center justify-center flex-shrink-0 w-8 h-8 bg-blue-100 rounded-full">
                        <x-heroicon-o-user class="w-4 h-4 text-blue-600" />
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-slate-900">{{ $user->name }}</p>
                        <p class="text-xs text-blue-600">Technicien</p>
                    </div>
                    <form action="{{ route('tickets.unassign', [$ticket, $user]) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="transition-colors text-slate-600 hover:text-red-600">
                            <x-heroicon-o-trash class="w-4 h-4" />
                        </button>
                    </form>
                </div>
            @empty
                <div
                    class="flex items-center gap-3 px-3 py-4 border border-dashed rounded-lg bg-slate-50 border-slate-200">
                    <div class="flex items-center justify-center flex-shrink-0 w-8 h-8 bg-white rounded-full">
                        <x-heroicon-o-user-plus class="w-4 h-4 text-slate-400" />
                    </div>
                    <p class="text-xs text-slate-500">
                        Aucun technicien assigné
                    </p>
                </div>
            @endforelse
        </div>

        <!-- Add User Form -->
        <form action="{{ route('tickets.assign', $ticket) }}" method="POST"
            class="flex flex-col gap-2 sm:flex-row sm:items-start">
            @csrf
            <div class="flex-1">
                <x-async-form-field name="user_id" route="{{ route('api.users.index') }}"
                    placeholder="Ajouter un technicien..." size="fill">
                    <div class="flex items-center space-x-3">
                        <div class="flex items-center justify-center flex-shrink-0 w-8 h-8 rounded-full bg-slate-100">
                            <x-heroicon-o-user class="w-5 h-5 text-gray-400" />
                        </div>
                        <div>
                            <div class="font-medium text-slate-900" data-key="full_name"></div>
                            <div class="text-xs text-slate-500" data-key="role"></div>
                        </div>
                    </div>
                </x-async-form-field>
            </div>
            <button type="submit"
                class="inline-flex items-center justify-center flex-shrink-0 w-full text-white transition-colors bg-blue-600 rounded-md sm:w-9 h-9 hover:bg-blue-700 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                <x-heroicon-o-plus class="w-5 h-5" />
                <span class="ml-2 sm:hidden">Ajouter</span>
            </button>
        </form>
    </div>
</div>
