<x-dashboard-layout>
    <x-dashboard.page-header title="Créer un technicien" description="Ajoutez un nouveau technicien dans le système." />

    <x-form action="{{ route('technicians.store') }}" method="POST" class="mt-6">
        @csrf

        {{-- Nom --}}
        <x-form-field name="name" label="Nom" placeholder="Jean Dupont" :value="old('name')" />

        {{-- Adresse e-mail --}}
        <x-form-field name="email" type="email" label="Adresse e-mail" placeholder="jean.dupont@example.com"
            icon="heroicon-o-envelope" :value="old('email')" />

        {{-- Mot de passe --}}
        <x-form-field name="password" type="password" label="Mot de passe" placeholder="••••••••"
            icon="heroicon-o-lock-closed" />

        {{-- Rôle --}}
        <x-form-field name="role" type="select" label="Rôle" :options="['admin' => 'Admin', 'technician' => 'Technicien']" :value="old('role')" />

        <x-slot name="actions">
            <x-button type="button" onclick="window.history.back()" color="danger" variant="soft" label="Annuler"
                icon="heroicon-o-x-mark" />
            <x-button type="submit" color="primary" variant="soft" label="Créer" icon="heroicon-o-check" />
        </x-slot>
    </x-form>
</x-dashboard-layout>
