@php

    $filters = [
        [
            'key' => 'status.code',
            'label' => 'Statut',
            'type' => 'select',
            'options' => [
                'open' => 'Ouvert',
                'closed' => 'Fermé',
                'pending' => 'En attente',
            ],
            'unselectable' => true,
            'placeholder' => 'Tous',
        ],
        [
            'key' => 'priority.code',
            'label' => 'Priorité',
            'type' => 'select',
            'options' => [
                'low' => 'Faible',
                'medium' => 'Moyen',
                'high' => 'Élevé',
            ],
            'unselectable' => true,
            'placeholder' => 'Toutes',
        ],
        [
            'key' => 'title',
            'label' => 'Titre',
            'type' => 'text',
            'placeholder' => 'Rechercher par titre',
            'operator' => 'like',
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
        [
            'key' => 'customer.first_name',
            'label' => 'Prénom du client',
            'type' => 'text',
            'placeholder' => 'Rechercher par prénom',
            'operator' => 'like',
            'half' => true,
        ],
        [
            'key' => 'customer.last_name',
            'label' => 'Nom du client',
            'type' => 'text',
            'placeholder' => 'Rechercher par nom',
            'operator' => 'like',
            'half' => true,
        ],
    ];

    $columns = [
        'id' => [
            'label' => 'ID',
            'key' => 'id',
            'href' => fn($row) => route('tickets.show', $row),
            'sortable' => true,
            'format' => fn($value) => '# ' . $value,
        ],
        'status' => [
            'label' => 'Status',
            'slot' => 'dashboard.tickets.partials.status-cell',
        ],
        'title' => [
            'label' => 'Intitulé',
            'key' => 'title',
            'href' => fn($row) => route('tickets.show', $row),
            'icon' => 'heroicon-o-ticket',
            'sortable' => true,
        ],
        'client' => [
            'label' => 'Client',
            'key' => 'customer.full_name',
            'href' => fn($row) => route('customers.show', $row->customer),
            'icon' => 'heroicon-o-user',
            'sortable' => true,
        ],
        'date' => [
            'label' => 'Ouvert le',
            'key' => 'created_at',
            'format' => fn($value) => \Carbon\Carbon::parse($value)->format('d/m/Y'),
            'icon' => 'heroicon-o-calendar',
            'sortable' => true,
        ],
    ];
@endphp

<x-dashboard-layout>
    <x-dashboard.page-header title="Tickets" description="Parcourez la liste des tickets ci-dessous.">
        <x-slot name="actions">
            <x-button variant="soft" color="primary" label="Ouvrir un ticket" icon="heroicon-o-plus"
                href="{{ route('tickets.create') }}" />
        </x-slot>
    </x-dashboard.page-header>

    <x-data-table :columns="$columns" :rows="$tickets" searchable :filters="$filters" />
</x-dashboard-layout>
