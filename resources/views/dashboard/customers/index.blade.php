<x-dashboard-layout>
    <x-dashboard.page-header title="Clients" description="Gérer vos clients et leurs informations.">
        <x-slot name="actions">
            <x-button color="primary" variant="soft" label="Nouveau Client" icon="heroicon-o-plus"
                href="{{ route('customers.create') }}" />
        </x-slot>
    </x-dashboard.page-header>

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
