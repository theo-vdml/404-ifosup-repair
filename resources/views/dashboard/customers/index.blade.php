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

    $filters = [
        [
            'type' => 'text',
            'key' => 'first_name',
            'label' => 'Prénom',
            'placeholder' => 'Rechercher par prénom',
            'operator' => 'like',
            'half' => true,
        ],
        [
            'type' => 'text',
            'key' => 'last_name',
            'label' => 'Nom',
            'placeholder' => 'Rechercher par nom',
            'operator' => 'like',
            'half' => true,
        ],
        [
            'type' => 'text',
            'key' => 'email',
            'label' => 'Email',
            'placeholder' => 'Rechercher par email',
            'operator' => 'like',
        ],
        [
            'type' => 'text',
            'key' => 'phone',
            'label' => 'Téléphone',
            'placeholder' => 'Rechercher par téléphone',
            'operator' => 'like',
        ],
        [
            'key' => 'address',
            'label' => 'Adresse',
            'type' => 'text',
            'placeholder' => 'Rechercher par adresse',
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
    ];
@endphp

<x-dashboard-layout>
    <x-dashboard.page-header title="Clients" description="Gérer vos clients et leurs informations.">
        <x-slot name="actions">
            @can('create', App\Models\Customer::class)
            <x-button color="primary" variant="soft" label="Nouveau Client" icon="heroicon-o-plus"
                href="{{ route('customers.create') }}" />
            @endcan
        </x-slot>
    </x-dashboard.page-header>

    <x-data-table :columns="$columns" :rows="$customers" :filters="$filters" />

</x-dashboard-layout>
