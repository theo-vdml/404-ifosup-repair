<x-dashboard-layout>
    <!-- Header Section -->
    <div class="mb-6">
        <x-button href="{{ route('technicians.index') }}" variant="ghost" color="secondary" icon="heroicon-o-arrow-left"
            label="Retour à la liste" class="pl-0 mb-4" />
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">{{ $technician->name }}</h1>
                <p class="mt-1 text-sm text-gray-500">Technicien • Créé le {{ $technician->created_at->format('d/m/Y') }}</p>
            </div>
            <div class="flex items-center space-x-3">
                <x-button form="technician-form" type="submit" variant="soft" color="primary" icon="heroicon-o-check" label="Enregistrer" />
                <x-button x-data="" x-on:click.prevent="$dispatch('open-modal', 'confirm-technician-deletion')"
                    variant="soft" color="danger" icon="heroicon-o-trash" label="Supprimer" />
            </div>
        </div>
    </div>

    <x-form id="technician-form" action="{{ route('technicians.update', $technician) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        <!-- Account Details -->
        <div class="bg-white p-6 border border-gray-200 rounded-lg">
            <h3 class="flex items-center mb-4 text-lg font-semibold text-gray-900">
                <x-heroicon-o-user class="w-5 h-5 mr-2 text-gray-600" />
                Informations du compte
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <x-form-field name="name" label="Nom" :value="$technician->name" />
                <x-form-field name="email" type="email" label="Adresse e-mail" :value="$technician->email" />
            </div>
        </div>

        <!-- Permissions -->
        <div class="bg-white p-6 border border-gray-200 rounded-lg">
            <h3 class="flex items-center mb-4 text-lg font-semibold text-gray-900">
                <x-heroicon-o-shield-check class="w-5 h-5 mr-2 text-gray-600" />
                Permissions et accès
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <x-form-field name="role" type="select" label="Rôle" :options="['admin' => 'Admin', 'technician' => 'Technicien']"
                    :value="$technician->role->value" />
            </div>
        </div>

        <!-- Sécurité -->
        <div class="bg-white p-6 border border-gray-200 rounded-lg">
            <h3 class="flex items-center mb-4 text-lg font-semibold text-gray-900">
                <x-heroicon-o-lock-closed class="w-5 h-5 mr-2 text-gray-600" />
                Sécurité
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <x-form-field name="password" type="password" label="Nouveau mot de passe" />
                <x-form-field name="password_confirmation" type="password" label="Confirmer le mot de passe" />
            </div>
        </div>
    </x-form>

    <x-modal name="confirm-technician-deletion" focusable>
        <form method="post" action="{{ route('technicians.destroy', $technician) }}" class="p-6">
            @csrf
            @method('delete')

            <h2 class="text-lg font-medium text-gray-900">
                Êtes-vous sûr de vouloir supprimer ce technicien ?
            </h2>

            <p class="mt-1 text-sm text-gray-600">
                Une fois supprimé, toutes les données du technicien seront perdues. Cette action est irréversible.
            </p>

            <div class="flex justify-end gap-2">
                <x-button color="secondary" variant="soft" label="Non, annuler" icon="heroicon-o-x-mark"
                    x-on:click.prevent="$dispatch('close')" />
                <x-button type="submit" color="danger" variant="soft" label="Oui, supprimer" icon="heroicon-o-trash" />
            </div>
        </form>
    </x-modal>
</x-dashboard-layout>
