@php
    $columns = [
        'id' => [
            'label' => 'ID',
            'key' => 'id',
            'href' => fn($row) => route('tickets.show', $row),
            'sortable' => true,
            'format' => fn($value) => '# ' . $value,
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

    $options = [
        'hide_headers_on_empty' => true,
    ];
@endphp

<x-dashboard-layout>
    <x-dashboard.page-header title="Mes Tickets" description="Parcourez la liste des tickets qui vous sont assignés." />

    <x-data-table :columns="$columns" :rows="$tickets" searchable :options="$options">
        <x-slot name="empty">
            <div class="flex flex-col items-center justify-center py-8 space-y-4">
                <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center">
                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z" />
                    </svg>
                </div>
                <div class="text-center space-y-1">
                    <h3 class="text-lg font-medium text-gray-900">Aucun ticket assigné</h3>
                    <p class="text-sm text-gray-500">
                        Vous n'avez actuellement aucun ticket ouvert qui vous est assigné.
                    </p>
                </div>
            </div>
        </x-slot>
    </x-data-table>
</x-dashboard-layout>
