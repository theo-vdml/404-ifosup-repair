@php
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
            'sortable' => true,
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

    <x-data-table-v2 :columns="$columns" :rows="$tickets" searchable />
</x-dashboard-layout>
