<x-dashboard-layout>
    <!-- Header Section -->
    <div class="mb-6">
        <x-button href="{{ route('customers.index') }}" variant="ghost" color="secondary" icon="heroicon-o-arrow-left"
            label="Retour a la liste" class="pl-0 mb-4" />
        <div>
            <h1 class="text-4xl font-bold text-slate-900">{{ $customer->full_name }}</h1>
            <p class="mt-2 text-slate-600">Créé le
                {{ $customer->created_at->format('d F Y') }}</p>
            <p class="text-slate-600">Dernière mise à jour le {{ $customer->updated_at->format('d F Y') }}</p>
        </div>
    </div>

    <div class="flex items-center justify-start gap-2 mb-6">
        @can('create', App\Models\Ticket::class)
        <x-button variant="soft" color="primary" icon="heroicon-o-ticket" label="Ouvrir un ticket" />
        @endcan
        @can('update', $customer)
        <x-button variant="soft" color="secondary" icon="heroicon-o-pencil" label="Modifier"
            href="{{ route('customers.edit', $customer) }}" />
        @endcan
        @can('delete', $customer)
        <x-button x-data="" x-on:click.prevent="$dispatch('open-modal', 'confirm-customer-deletion')"
            variant="soft" color="danger" icon="heroicon-o-trash" label="Supprimer" />
        @endcan
    </div>

    <!-- Main Content -->
    <div class="grid grid-cols-1 gap-8 lg:grid-cols-3">
        <!-- Personal Information -->
        <div class="lg:col-span-2">
            <div class="p-8 bg-white border shadow-sm border-slate-200 rounded-xl">
                <h3 class="flex items-center mb-6 text-xl font-semibold text-slate-900">
                    <x-heroicon-o-user class="w-6 h-6 mr-3 text-slate-800" />
                    Informations personnelles
                </h3>
                <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                    <div class="space-y-4">
                        <div>
                            <label class="block mb-1 text-sm font-bold text-slate-700">Nom complet</label>
                            <p class="text-slate-900">{{ $customer->full_name }}</p>
                        </div>
                        <div>
                            <label class="block mb-1 text-sm font-bold text-slate-700">Email</label>
                            <a href="mailto:{{ $customer->email }}" class="hover:underline">{{ $customer->email }}</a>
                        </div>
                    </div>
                    <div class="space-y-4">
                        <div>
                            <label class="block mb-1 text-sm font-bold text-slate-700">Téléphone</label>
                            @if ($customer->phone)
                                <a href="tel:{{ $customer->phone }}" class="hover:underline">{{ $customer->phone }}</a>
                            @else
                                <span class="italic text-slate-400">—</span>
                            @endif
                        </div>
                        <div>
                            <label class="block mb-1 text-sm font-bold text-slate-700">Adresse</label>
                            @if ($customer->address)
                                <p class="text-slate-900 ">{{ $customer->address }}</p>
                            @else
                                <span class="italic text-slate-400 ">—</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Notes Section -->
            <div class="p-8 mt-8 bg-white border shadow-sm border-slate-200 rounded-xl">
                <h3 class="flex items-center mb-6 text-xl font-semibold text-slate-900">
                    <x-heroicon-o-document-text class="w-6 h-6 mr-3 text-slate-800" />
                    Notes personnelles
                </h3>
                <div class="bg-slate-50 rounded-lg p-4 min-h-[100px]">
                    @if ($customer->notes)
                        <p class="whitespace-pre-line text-slate-700">{{ $customer->notes }}</p>
                    @else
                        <p class="italic text-slate-400">Aucune note pour ce client.</p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Actions Sidebar -->
        <div class="space-y-4">
            <div class="p-6 bg-white border shadow-sm border-slate-200 rounded-xl">
                <div class="flex items-center">
                    <div class="p-3 bg-blue-100 rounded-lg">
                        <x-heroicon-o-clock class="w-6 h-6 text-blue-600" />
                    </div>
                    <div class="ml-4">
                        <p class="text-2xl font-bold text-slate-900">
                            {{ $customer->tickets->where('is_open', true)->count() }}</p>
                        <p class="text-sm text-slate-600">Tickets ouverts</p>
                    </div>
                </div>
            </div>
            <div class="p-6 bg-white border shadow-sm border-slate-200 rounded-xl">
                <div class="flex items-center">
                    <div class="p-3 bg-green-100 rounded-lg">
                        <x-heroicon-o-check-circle class="w-6 h-6 text-green-600" />
                    </div>
                    <div class="ml-4">
                        <p class="text-2xl font-bold text-slate-900">
                            {{ $customer->tickets->where('is_closed', true)->count() }}</p>
                        <p class="text-sm text-slate-600">Tickets résolus</p>
                    </div>
                </div>
            </div>
            <div class="p-6 bg-white border shadow-sm border-slate-200 rounded-xl">
                <div class="flex items-center">
                    <div class="p-3 bg-orange-100 rounded-lg">
                        <x-heroicon-o-exclamation-triangle class="w-6 h-6 text-orange-600" />
                    </div>
                    <div class="ml-4">
                        <p class="text-2xl font-bold text-slate-900">{{ $customer->tickets->count() }}</p>
                        <p class="text-sm text-slate-600">Tickets non résolus</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <x-modal name="confirm-customer-deletion" focusable>
        <form method="post" action="{{ route('customers.destroy', $customer) }}" class="p-6">
            @csrf
            @method('delete')

            <h2 class="text-lg font-medium text-gray-900">
                Êtes-vous sûr de vouloir supprimer ce client ?
            </h2>

            <p class="mt-1 text-sm text-gray-600">
                Une fois supprimé, toutes les données du client seront perdues. Cette action est irréversible.
            </p>

            <div class="mt-6">
                <label class="flex items-center">
                    <input type="checkbox" name="delete_tickets" value="1"
                        class="text-indigo-600 border-gray-300 rounded shadow-sm focus:ring-indigo-500">
                    <span class="ml-2 text-sm text-gray-600">Supprimer aussi les tickets du client.</span>
                </label>
            </div>

            <div class="flex justify-end gap-2">

                <x-button color="secondary" variant="soft" label="Non, annuler" icon="heroicon-o-x-mark"
                    x-on:click.prevent="$dispatch('close')" />

                <x-button type="submit" color="danger" variant="soft" label="Oui, supprimer" icon="heroicon-o-trash" />
            </div>
        </form>
    </x-modal>
</x-dashboard-layout>
