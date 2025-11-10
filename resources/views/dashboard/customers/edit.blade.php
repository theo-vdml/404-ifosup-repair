<x-dashboard-layout>
    <x-dashboard.page-header title="Modifier un client"
        description="Modifiez les informations du client dans le système." />



    <!-- Client Info Card -->
    <div class="p-6 mb-6 bg-white rounded-lg shadow">
        <div class="flex items-center">
            <div class="flex-shrink-0">
                <x-heroicon-o-user class="w-8 h-8 text-gray-400" />
            </div>
            <div class="ml-4">
                <a class="hover:underline" href="{{ route('customers.show', $customer) }}">
                    <h3 class="text-lg font-medium text-gray-900">{{ $customer->full_name }}</h3>
                </a>
                <p class="text-sm text-gray-500">{{ $customer->email }}</p>
            </div>
        </div>
    </div>

    <x-form action="{{ route('customers.update', $customer) }}" method="POST" class="mt-6">
        @csrf
        @method('PUT')

        {{-- Prénom --}}
        <x-form-field name="first_name" label="Prénom" placeholder="Jean" size="half" :value="$customer->first_name" />

        {{-- Nom --}}
        <x-form-field name="last_name" label="Nom" placeholder="Dupont" size="half" :value="$customer->last_name" />

        {{-- Adresse e-mail --}}
        <x-form-field name="email" type="email" label="Adresse e-mail" placeholder="jean.dupont@example.com"
            icon="heroicon-o-envelope" :value="$customer->email" />

        {{-- Numéro de téléphone --}}
        <x-form-field name="phone" type="tel" label="Téléphone" placeholder="+33 6 12 34 56 78"
            icon="heroicon-o-phone" :value="$customer->phone" />

        {{-- Adresse --}}
        <x-form-field name="address" label="Adresse" placeholder="Rue de la Limite 6, 1300 Wavre" icon="heroicon-o-home"
            :value="$customer->address" />

        {{-- Message / Notes internes --}}
        <x-form-field name="notes" type="textarea" label="Notes"
            placeholder="Informations complémentaires sur le client (facultatif)." :value="$customer->notes" />

        <x-slot name="actions">
            <x-button onclick="window.history.back()" color="danger" variant="soft" label="Annuler"
                icon="heroicon-o-x-mark" />
            <x-button type="submit" color="primary" variant="soft" label="Enregistrer" icon="heroicon-o-check" />
        </x-slot>
    </x-form>
</x-dashboard-layout>
