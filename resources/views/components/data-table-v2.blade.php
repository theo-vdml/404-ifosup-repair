@props([
    'columns' => [],
    'rows' => [],
    'options' => [],
    'searchable' => false,
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
                    <td colspan="{{ count($columns) }}" class="px-6 py-12 text-center">
                        @isset($empty)
                            {{ $empty }}
                        @else
                            <div class="space-y-2 text-gray-400">
                                {{ svg(data_get($options, 'empty_icon', 'heroicon-o-document-text')) }}
                                <p class="text-sm font-medium text-gray-500">Aucune donnée disponible</p>
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
