@php
    $columns = [
        'id' => [
            'label' => 'ID',
            'key' => 'id',
            'href' => fn($row) => route('technicians.show', $row),
            'sortable' => true,
        ],
        'name' => [
            'label' => 'Nom',
            'key' => 'name',
            'href' => fn($row) => route('technicians.show', $row),
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
        'role' => [
            'label' => 'Rôle',
            'key' => 'role',
            'format' => fn($value) => $value->name,
            'icon' => 'heroicon-o-shield-check',
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

    $filters = [
        [
            'type' => 'text',
            'key' => 'name',
            'label' => 'Nom',
            'placeholder' => 'Rechercher par nom',
            'operator' => 'like',
        ],
        [
            'type' => 'text',
            'key' => 'email',
            'label' => 'Email',
            'placeholder' => 'Rechercher par email',
            'operator' => 'like',
        ],
        [
            'key' => 'role',
            'label' => 'Rôle',
            'type' => 'select',
            'options' => [
                'admin' => 'Admin',
                'technician' => 'Technicien',
            ],
            'unselectable' => true,
            'placeholder' => 'Tous',
        ],
        [
            'key' => 'created_at',
            'label' => 'Date de création (à partir de)',
            'type' => 'date',
            'operator' => 'gte',
            'half' => true,
        ],
        [
            'key' => 'created_at',
            'label' => 'Date de création (jusqu\'à)',
            'type' => 'date',
            'operator' => 'lte',
            'half' => true,
        ],
    ];
@endphp

<x-dashboard-layout>
    <x-dashboard.page-header title="Techniciens" description="Gérer vos techniciens et leurs informations.">
        <x-slot name="actions">
            <x-button color="primary" variant="soft" label="Nouveau Technicien" icon="heroicon-o-plus"
                href="{{ route('technicians.create') }}" />
        </x-slot>
    </x-dashboard.page-header>

    <x-data-table :columns="$columns" :rows="$technicians" :filters="$filters" />

</x-dashboard-layout>
