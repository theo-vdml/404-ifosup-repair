@props([
    'columns' => [],
    'rows' => [],
    'actions' => [],
])

<div class="overflow-x-auto bg-white border rounded-lg border-gray-200/60">
    <table class="min-w-[700px] w-full table-auto">
        <!-- Header -->
        <thead class="border-b border-gray-100 bg-gray-50">
            <tr>
                @foreach ($columns as $key => $col)
                    <th class="px-6 py-4 text-sm font-semibold text-gray-800 whitespace-nowrap">
                        <div class="flex items-center gap-2">
                            @if ($col['icon'] ?? false)
                                {{ svg($col['icon'], 'w-4 h-4 inline-block mr-2') }}
                            @endif
                            {{ $col['label'] ?? $key }}
                        </div>
                    </th>
                @endforeach
                @if (!empty($actions))
                    <th class="px-6 py-4 text-sm font-semibold text-left text-gray-800 whitespace-nowrap">Actions
                    </th>
                @endif
            </tr>
        </thead>

        <!-- Body -->
        <tbody>
            @forelse($rows as $row)
                <tr
                    class="transition-colors duration-150 border-b group border-gray-50 last:border-b-0 hover:bg-gray-50/50">
                    @foreach ($columns as $key => $col)
                        <td class="px-6 py-4 text-sm text-gray-700 whitespace-nowrap">
                            @if (isset($col['href']) && $col['href'])
                                <a href="{{ is_callable($col['href']) ? $col['href']($row) : $col['href'] }}"
                                    class="hover:underline">
                                    {{ is_array($row) ? $row[$key] ?? '' : $row->$key ?? '' }}
                                </a>
                            @else
                                {{ is_array($row) ? $row[$key] ?? '' : $row->$key ?? '' }}
                            @endif
                        </td>
                    @endforeach
                    @if (!empty($actions))
                        <td class="px-6 py-4 text-sm text-left whitespace-nowrap">
                            <div class="inline-flex items-center gap-2">
                                @foreach ($actions as $action)
                                    <x-button :color="$action['color'] ?? 'primary'" :variant="$action['variant'] ?? 'solid'" :icon="$action['icon'] ?? null" :label="$action['label'] ?? ''"
                                        :href="is_callable($action['href'])
                                            ? $action['href']($row)
                                            : $action['href'] ?? null" :size="$action['size'] ?? 'sm'" />
                                @endforeach
                            </div>
                        </td>
                    @endif
                </tr>
            @empty
                <tr>
                    <td colspan="{{ count($columns) + (!empty($actions) ? 1 : 0) }}" class="px-6 py-12 text-center">
                        <div class="space-y-2 text-gray-400">
                            <svg class="w-12 h-12 mx-auto text-gray-300" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                                    d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z">
                                </path>
                            </svg>
                            <p class="text-sm font-medium text-gray-500">Aucune donnée disponible</p>
                        </div>
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
