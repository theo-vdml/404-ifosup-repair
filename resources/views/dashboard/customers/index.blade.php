@php
    $columns = [
        'id' => [
            'label' => 'ID',
            'key' => 'id',
            'href' => fn($row) => route('customers.show', $row),
            'sortable' => true,
        ],
        'full_name' => [
            'label' => 'Nom',
            'key' => 'full_name',
            'href' => fn($row) => route('customers.show', $row),
            'icon' => 'heroicon-o-user',
            'sortable' => true,
        ],
        'email' => [
            'label' => 'Email',
            'key' => 'email',
            'href' => fn($row) => 'mailto:' . $row->email,
            'icon' => 'heroicon-o-envelope',
            'sortable' => true,
        ],
        'created_at' => [
            'label' => 'Créé le',
            'key' => 'created_at',
            'format' => fn($value) => \Carbon\Carbon::parse($value)->format('d/m/Y'),
            'icon' => 'heroicon-o-calendar',
            'sortable' => true,
        ],
    ];
@endphp

<x-dashboard-layout>
    <x-dashboard.page-header title="Clients" description="Gérer vos clients et leurs informations.">
        <x-slot name="actions">
            <x-button color="primary" variant="soft" label="Nouveau Client" icon="heroicon-o-plus"
                href="{{ route('customers.create') }}" />
        </x-slot>
    </x-dashboard.page-header>

    <x-data-table-v2 :columns="$columns" :rows="$customers" />

</x-dashboard-layout>
