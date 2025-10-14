<x-dashboard-layout>
    <x-dashboard.page-header title="Créer un nouveau client"
        description="Remplissez les informations du client pour l’ajouter au système." />

    <x-form action="{{ route('customers.store') }}" method="POST" class="mt-6">
        @csrf

        {{-- Prénom --}}
        <x-form-field name="first_name" label="Prénom" placeholder="Jean" size="half" />

        {{-- Nom --}}
        <x-form-field name="last_name" label="Nom" placeholder="Dupont" size="half" />

        {{-- Adresse e-mail --}}
        <x-form-field name="email" type="email" label="Adresse e-mail" placeholder="jean.dupont@example.com"
            icon="heroicon-o-envelope" />

        {{-- Numéro de téléphone --}}
        <x-form-field name="phone" type="tel" label="Téléphone" placeholder="+33 6 12 34 56 78"
            icon="heroicon-o-phone" />

        {{-- Adresse --}}
        <x-form-field name="address" label="Adresse" placeholder="Rue de la Limite 6, 1300 Wavre"
            icon="heroicon-o-home" />

        {{-- Message / Notes internes --}}
        <x-form-field name="notes" type="textarea" label="Notes"
            placeholder="Informations complémentaires sur le client (facultatif)." />

        <x-slot name="actions">
            <x-button onclick="window.history.back()" color="danger" variant="soft" label="Annuler"
                icon="heroicon-o-x-mark" />
            <x-button type="submit" name="create_ticket" color="secondary" variant="outline"
                label="Créer & Ouvrir un ticket" icon="heroicon-o-ticket" />
            <x-button type="submit" name="create_customer" color="primary" variant="soft" label="Créer le client"
                icon="heroicon-o-plus" />
        </x-slot>
    </x-form>
</x-dashboard-layout>
