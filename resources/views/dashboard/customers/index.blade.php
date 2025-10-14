<x-dashboard-layout>
    <x-dashboard.page-header title="Clients" description="Gérer vos clients et leurs informations.">
        <x-slot name="actions">
            <x-button color="primary" variant="soft" label="Nouveau Client" icon="heroicon-o-plus"
                href="{{ route('customers.create') }}" />
        </x-slot>
    </x-dashboard.page-header>

    <div class="mb-6">
        <form method="GET" action="{{ route('customers.index') }}" x-data="{ showAdvanced: {{ request('advanced_search', false) ? 'true' : 'false' }} }"
            class="p-6 bg-white border rounded-lg shadow-sm border-slate-200">
            <div class="space-y-4">
                <div class="flex flex-col gap-4 md:flex-row md:items-end">
                    <!-- Search Input -->
                    <div class="flex-1">
                        <label for="search" class="block mb-2 text-sm font-medium text-slate-700">Rechercher</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </div>
                            <input type="text" name="search" id="search" value="{{ request('search') }}"
                                placeholder="Rechercher des clients..."
                                class="block w-full py-2 pl-10 pr-3 leading-5 bg-white border rounded-md border-slate-300 placeholder-slate-500 focus:outline-none focus:ring-slate-500 focus:border-slate-500 sm:text-sm">
                        </div>
                    </div>

                    <!-- Order By -->
                    <div class="w-full md:w-40">
                        <label for="order_by" class="block mb-2 text-sm font-medium text-slate-700">Trier par</label>
                        <select name="order_by" id="order_by"
                            class="block w-full px-3 py-2 bg-white border rounded-md shadow-sm border-slate-300 focus:outline-none focus:ring-slate-500 focus:border-slate-500 sm:text-sm">
                            <option value="created_at_desc"
                                {{ request('order_by') == 'created_at_desc' ? 'selected' : '' }}>Plus récent</option>
                            <option value="created_at_asc"
                                {{ request('order_by') == 'created_at_asc' ? 'selected' : '' }}>
                                Plus ancien</option>
                            <option value="full_name_asc"
                                {{ request('order_by') == 'full_name_asc' ? 'selected' : '' }}>Nom
                                A-Z</option>
                            <option value="full_name_desc"
                                {{ request('order_by') == 'full_name_desc' ? 'selected' : '' }}>
                                Nom Z-A</option>
                            <option value="email_asc" {{ request('order_by') == 'email_asc' ? 'selected' : '' }}>Email
                                A-Z
                            </option>
                            <option value="email_desc" {{ request('order_by') == 'email_desc' ? 'selected' : '' }}>Email
                                Z-A
                            </option>
                        </select>
                    </div>
                </div>

                <!-- Toggle Advanced Search -->
                <div class="flex flex-row items-center justify-end gap-2">
                    <x-button type="button" @click="showAdvanced = !showAdvanced" variant="outline" color="secondary"
                        size="sm" label="Recherche avancée" class="whitespace-nowrap" />
                    <x-button x-show="!showAdvanced" type="submit" name="filter" value="1" variant="soft"
                        color="primary" size="sm" label="Filtrer" icon="heroicon-o-funnel" />
                </div>
            </div>

            <!-- Advanced Search -->
            <div x-show="showAdvanced" x-transition
                class="px-6 pt-6 pb-6 mt-6 -mx-6 -mb-6 border-t rounded-b-lg border-slate-200">
                <h3 class="mb-2 text-base font-semibold text-slate-900">Recherche avancée</h3>
                <div class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-4">
                    <div>
                        <label for="name" class="block mb-2 text-sm font-medium text-slate-700">Nom</label>
                        <input type="text" name="name" id="name" value="{{ request('name') }}"
                            placeholder="Prénom ou nom..."
                            class="block w-full px-3 py-2 border rounded-md shadow-sm border-slate-300 focus:outline-none focus:ring-slate-500 focus:border-slate-500 sm:text-sm">
                    </div>
                    <div>
                        <label for="email_filter" class="block mb-2 text-sm font-medium text-slate-700">Email</label>
                        <input type="text" name="email" id="email_filter" value="{{ request('email') }}"
                            placeholder="Adresse email..."
                            class="block w-full px-3 py-2 border rounded-md shadow-sm border-slate-300 focus:outline-none focus:ring-slate-500 focus:border-slate-500 sm:text-sm">
                    </div>
                    <div>
                        <label for="phone" class="block mb-2 text-sm font-medium text-slate-700">Téléphone</label>
                        <input type="text" name="phone" id="phone" value="{{ request('phone') }}"
                            placeholder="Numéro de téléphone..."
                            class="block w-full px-3 py-2 border rounded-md shadow-sm border-slate-300 focus:outline-none focus:ring-slate-500 focus:border-slate-500 sm:text-sm">
                    </div>
                    <div>
                        <label for="address" class="block mb-2 text-sm font-medium text-slate-700">Adresse</label>
                        <input type="text" name="address" id="address" value="{{ request('address') }}"
                            placeholder="Adresse..."
                            class="block w-full px-3 py-2 border rounded-md shadow-sm border-slate-300 focus:outline-none focus:ring-slate-500 focus:border-slate-500 sm:text-sm">
                    </div>
                </div>
                <div class="flex justify-end pt-4 mt-6 border-t border-slate-200">
                    <x-button type="submit" name="advanced_search" variant="soft" color="primary" size="base"
                        label="Filter et Rechercher" icon="heroicon-o-magnifying-glass" value="1" />
                </div>
            </div>
        </form>
    </div>

    <x-data-table :columns="[
        'id' => [
            'label' => 'ID',
            'align' => 'text-center',
            'href' => fn($row) => route('customers.show', $row),
        ],
        'full_name' => [
            'label' => 'Nom',
            'icon' => 'heroicon-o-user',
            'href' => fn($row) => route('customers.show', $row),
        ],
        'email' => [
            'label' => 'Email',
            'icon' => 'heroicon-o-envelope',
            'href' => fn($row) => 'mailto:' . $row->email,
        ],
        'created_at' => [
            'label' => 'Créé le',
            'mobile' => false,
            'format' => fn($value) => \Carbon\Carbon::parse($value)->format('d/m/Y'),
            'icon' => 'heroicon-o-calendar',
        ],
    ]" :rows="$customers" />

</x-dashboard-layout>
