@props([
    'columns' => [],
    'rows' => [],
    'options' => [],
    'searchable' => false,
    'filters' => [],
])

@php
    $renderDynamicSlot = function ($slot, array $data = []) {
        if (blank($slot)) {
            return null;
        }

        if (is_callable($slot)) {
            $slot = $slot(...array_values($data));
        }

        if (is_string($slot) && str_starts_with($slot, 'view:')) {
            return view(substr($slot, 5))->with($data)->render();
        }

        if ($slot instanceof \Illuminate\Support\HtmlString) {
            return $slot->toHtml();
        }

        if (is_string($slot)) {
            try {
                return \Illuminate\Support\Facades\Blade::render($slot, $data);
            } catch (\Throwable $e) {
                return $slot;
            }
        }

        return (string) $slot;
    };

    $getBreakpointClass = function ($breakpoint) {
        return match ($breakpoint) {
            'sm' => 'hidden sm:table-cell',
            'md' => 'hidden md:table-cell',
            'lg' => 'hidden lg:table-cell',
            'xl' => 'hidden xl:table-cell',
            '2xl' => 'hidden 2xl:table-cell',
            default => '',
        };
    };

    $headerCellBaseClass = 'px-6 py-4 text-sm font-semibold text-gray-800 whitespace-nowrap border border-gray-200/60';
    $dataRowBaseClass =
        'transition-colors duration-150 border-b group border-gray-50 last:border-b-0 hover:bg-gray-50/50';
    $dataCellBaseClass = 'px-6 py-4 text-sm text-gray-700 whitespace-nowrap';
@endphp

@if (!empty($filters))
    <div class="mb-6 flex justify-end">
        <div x-data="{ modalOpen: false }" class="relative">
            <button @click="modalOpen = true"
                class="inline-flex items-center gap-2 px-4 py-2.5 text-sm font-medium text-slate-700 bg-white border border-slate-300 rounded-lg hover:bg-slate-50 hover:border-slate-400 transition-all shadow-sm focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z">
                    </path>
                </svg>
                Filtres
                @if (request()->has('filter'))
                    <span
                        class="inline-flex items-center justify-center min-w-[20px] h-5 px-1.5 text-xs font-semibold text-white bg-blue-600 rounded-full">
                        {{ count(request()->input('filter', [])) }}
                    </span>
                @endif
            </button>

            <!-- Modal -->
            <div x-show="modalOpen" x-cloak x-transition.opacity.duration.300ms
                class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50"
                @click.self="modalOpen = false">
                <div class="w-full max-w-3xl max-h-[90vh] overflow-y-auto bg-white rounded-lg shadow-xl">
                    <div class="flex items-center justify-between p-6 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">Filtres</h3>
                    </div>
                    <div class="p-6">
                        <x-form method="GET" action="{{ request()->url() }}">
                            @foreach (request()->except('filter') as $key => $value)
                                @if (is_array($value))
                                    @foreach ($value as $arrayValue)
                                        <input type="hidden" name="{{ $key }}[]" value="{{ $arrayValue }}">
                                    @endforeach
                                @else
                                    <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                                @endif
                            @endforeach

                            @foreach ($filters as $filter)
                                @if (array_key_exists('key', $filter))
                                    @php
                                        $key = $filter['key'];
                                        $operator = $filter['operator'] ?? 'eq';
                                        $label = $filter['label'] ?? $key;
                                        $type = $filter['type'];
                                        $options = $filter['options'] ?? null;
                                        $half = $filter['half'] ?? false;
                                        $unselectable = $filter['unselectable'] ?? false;
                                        $placeholder = $filter['placeholder'] ?? null;
                                        $fieldName = "filter[{$key}][{$operator}]";
                                        $value = filterValue($key, $operator);
                                        $size = $half ? 'half' : 'fill';
                                        $defaultOption = $unselectable
                                            ? ['label' => $placeholder, 'value' => '']
                                            : null;
                                    @endphp
                                    <x-form-field name="{{ $fieldName }}" label="{{ $label }}"
                                        type="{{ $type }}" :options="$options" value="{{ $value ?? '' }}"
                                        size="{{ $size }}" :defaultOption="$defaultOption"
                                        placeholder="{{ $placeholder }}" />
                                @endif
                            @endforeach

                            <x-slot name="actions">
                                <x-button type="button" @click="modalOpen = false" variant="soft" label="Annuler"
                                    color="secondary" />
                                <x-button type="button" href="{{ clearAllFiltersUrl() }}" label="Effacer tout"
                                    variant="soft" color="danger" />
                                <x-button type="submit" label="Appliquer" variant="soft" />
                            </x-slot>
                        </x-form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif

<div class="overflow-x-auto bg-white border rounded-lg border-gray-200/60">
    <table class="min-w-[700px] w-full table-auto">
        <!-- Header -->
        <thead class="border-b border-gray-100 bg-gray-50">
            <tr>
                @foreach ($columns as $id => $colOptions)
                    @php
                        // Icon for header if provided
                        $icon = data_get($colOptions, 'icon', null);

                        $sortable = data_get($colOptions, 'sortable', false);
                        $sortableKey = $sortable
                            ? (is_string($sortable)
                                ? $sortable
                                : data_get($colOptions, 'key', $id))
                            : null;

                        $sortIcon = match ($sortableKey ? sortState($sortableKey) : null) {
                            'asc' => 'heroicon-s-chevron-up',
                            'desc' => 'heroicon-s-chevron-down',
                            default => 'heroicon-s-arrows-up-down',
                        };

                        // Get header classes
                        $headerClasses = collect([
                            $headerCellBaseClass,
                            data_get($colOptions, 'align', 'text-left'),
                            $getBreakpointClass(data_get($colOptions, 'breakpoint', null)),
                            data_get($colOptions, 'ui.header', ''),
                        ])
                            ->filter()
                            ->join(' ');
                    @endphp

                    <th class="{{ $headerClasses }}"
                        @if ($sortable) role="button" onclick="window.location = '{{ sortableUrl($sortableKey) }}'" @endif>
                        <div class="flex items-center gap-2">
                            {{-- Label + Icon --}}
                            @if ($icon)
                                {{ svg($icon, 'w-4 h-4 ' . data_get($colOptions, 'ui.icon', '')) }}
                            @endif

                            <span class="flex-1 {{ data_get($colOptions, 'ui.label', '') }}">
                                {{ data_get($colOptions, 'label', $id) }}
                            </span>

                            @if ($sortable)
                                {{-- Icône de tri --}}
                                <span
                                    class="flex items-center justify-center w-3 h-3 text-gray-600 group-hover:text-gray-900">
                                    {{ svg($sortIcon, 'w-3 h-3') }}
                                </span>
                            @endif
                        </div>
                    </th>
                @endforeach
            </tr>
        </thead>

        <!-- Body -->
        <tbody>
            @forelse($rows as $row)
                <tr class="{{ $dataRowBaseClass }}">
                    @foreach ($columns as $id => $colOptions)
                        @php
                            $slot = $renderDynamicSlot(data_get($colOptions, 'slot', null), [
                                'row' => $row,
                            ]);

                            $value = data_get($row, data_get($colOptions, 'key', $id), null);
                            if (is_callable(data_get($colOptions, 'format', null))) {
                                $value = data_get($colOptions, 'format')($value, $row);
                            }

                            $href = data_get($colOptions, 'href', null);
                            if (is_callable($href)) {
                                $href = $href($row);
                            }

                            $cellClasses = collect([
                                $dataCellBaseClass,
                                data_get($colOptions, 'align', 'text-left'),
                                $getBreakpointClass(data_get($colOptions, 'breakpoint', null)),
                                data_get($colOptions, 'ui.cell', ''),
                            ])
                                ->filter()
                                ->join(' ');

                        @endphp

                        <td class="{{ $cellClasses }}">
                            @if ($slot)
                                {!! $slot !!}
                            @elseif ($href)
                                <a href="{{ $href }}" class="hover:underline">
                                    {{ $value }}
                                </a>
                            @elseif ($value)
                                {{ $value }}
                            @else
                                <span class="text-gray-400 italic">—</span>
                            @endif
                        </td>
                    @endforeach
                </tr>
            @empty
                <tr>
                    <td colspan="{{ count($columns) }}"
                        class="px-6 py-16 text-center bg-gradient-to-b from-slate-50/50 to-white">
                        @isset($empty)
                            {{ $empty }}
                        @else
                            <div class="flex flex-col items-center justify-center space-y-4">
                                <!-- Icon -->
                                <div class="w-16 h-16 bg-slate-100 rounded-full flex items-center justify-center">
                                    {{ svg(data_get($options, 'empty_icon', 'heroicon-o-document-text'), 'w-8 h-8 text-slate-400') }}
                                </div>

                                <!-- Text -->
                                <div class="space-y-1">
                                    <p class="text-base font-semibold text-slate-900">
                                        {{ data_get($options, 'empty_title', 'Aucune donnée disponible') }}
                                    </p>
                                    <p class="text-sm text-slate-500">
                                        {{ data_get($options, 'empty_description', 'Les données apparaîtront ici une fois ajoutées.') }}
                                    </p>
                                </div>
                            </div>
                        @endisset
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

{{-- Pagination --}}
@if (method_exists($rows, 'links'))
    <div class="mt-6">
        {{ $rows->links() }}
    </div>
@endif
