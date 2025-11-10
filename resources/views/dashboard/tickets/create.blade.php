<x-dashboard-layout>
    <x-dashboard.page-header title="Ouvrir un nouveau ticket"
        description="Remplissez les informations ci-dessous pour créer un nouveau ticket." />

    <div class="p-12 bg-white border rounded-lg shadow-sm border-slate-200">
        <x-form action="{{ route('tickets.store') }}" method="POST">
            <x-async-form-field name="customer_id" icon="heroicon-o-user" label="Client concerné"
                route="{{ route('api.customers.index') }}" placeholder="Rechercher un client..." size="half">
                <div class="flex items-center space-x-3">
                    <div class="flex items-center justify-center flex-shrink-0 w-8 h-8 rounded-full bg-slate-100">
                        <x-heroicon-o-user class="w-5 h-5 text-gray-400" />
                    </div>
                    <div>
                        <div class="font-medium text-slate-900" data-key="full_name"></div>
                        <div class="text-sm text-slate-500" data-key="email"></div>
                    </div>
                </div>
            </x-async-form-field>

            <x-form-field name="priority" label="Priorité" type="select" size="half" :value="old('priority', 'medium')"
                :options="[
                    'low' => 'Basse',
                    'medium' => 'Moyenne',
                    'high' => 'Haute',
                    'urgent' => 'Urgente',
                ]" />

            <x-form-field name="title" label="Intitulé du ticket" placeholder="Problème avec mon ordinateur"
                icon="heroicon-o-ticket" />

            <x-form-field name="description" type="textarea" label="Description du problème"
                placeholder="Décrivez le problème rencontré par le client." icon="heroicon-o-document-text" />


            <x-slot name="actions">
                <x-button type="button" onclick="window.history.back()" color="danger" variant="soft" label="Annuler"
                    icon="heroicon-o-x-mark" />
                <x-button type="submit" color="primary" variant="soft" label="Créer le ticket"
                    icon="heroicon-o-check" />
            </x-slot>

        </x-form>
    </div>
</x-dashboard-layout>
