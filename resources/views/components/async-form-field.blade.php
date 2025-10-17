@props([
    'name' => null,
    'label' => null,
    'description' => null,
    'icon' => null,
    'route' => null,
    'size' => 'fill', // fill | half
    'value' => null,
    'options' => [
        'label_key' => 'full_name',
        'value_key' => 'id',
    ],
])

@php
    $colSpan = $size === 'half' ? 'lg:col-span-1' : 'lg:col-span-2';
    $fieldBase =
        'w-full rounded-md border bg-white/70 backdrop-blur-sm px-3 py-2 text-sm transition-shadow transition-colors shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-0';
    $errorClasses = $errors->has($name) ? 'border-red-500 focus:ring-red-300' : 'border-gray-200 focus:ring-indigo-300';
    $withIconPadding = $icon ? 'pl-10' : '';
@endphp

<div class="{{ $colSpan }} space-y-2" x-data="asyncSelect({
    endpoint: '{{ $route }}',
    labelKey: '{{ $options['label_key'] ?? 'full_name' }}',
    valueKey: '{{ $options['value_key'] ?? 'id' }}',
    initialValue: '{{ old($name, $value) }}'
})" x-init="init()">

    {{-- Label --}}
    @if ($label)
        <label for="{{ $name }}" class="block text-sm font-semibold text-gray-700">
            {{ $label }}
        </label>
    @endif

    {{-- Input wrapper --}}
    <div class="relative">


        {{-- Input --}}
        <input type="text" id="{{ $name }}-search" x-model="query" x-on:input.debounce.300ms="search"
            x-on:blur="validateSelect()" autocomplete="off" {{ $attributes->merge(['placeholder' => 'Rechercher...']) }}
            aria-invalid="{{ $errors->has($name) ? 'true' : 'false' }}"
            class="{{ $fieldBase }} h-10 {{ $errorClasses }} {{ $withIconPadding }}">

        {{-- Spinner --}}
        <div x-show="searching" class="absolute right-3 top-1/2 -translate-y-1/2">
            <x-heroicon-o-arrow-path class="w-4 h-4 text-gray-400 animate-spin" />
        </div>

        {{-- Dropdown --}}
        <template x-if="results.length > 0">
            <ul x-show="results.length > 0" x-transition
                class="absolute z-10 w-full bg-white border border-gray-200 rounded-md shadow-lg mt-1 max-h-60 overflow-auto">
                <template x-for="(item, index) in results" :key="item[valueKey]">
                    <li class="px-3 py-2 text-sm text-gray-700 cursor-pointer hover:bg-gray-100"
                        x-on:mousedown.prevent="select(item)" :data-item-index="index" x-init="renderItem($el, item)">
                        @if ($slot)
                            {{ $slot }}
                        @else
                            <span x-text="item[labelKey]"></span>
                        @endif
                    </li>
                </template>
            </ul>
        </template>

        @if ($icon)
            <div class="absolute text-gray-400 -translate-y-1/2 pointer-events-none left-3 top-1/2">
                {{ svg($icon, 'w-5 h-5') }}
            </div>
        @endif

        {{-- Hidden field --}}
        <input type="hidden" name="{{ $name }}" x-model="selectedId">
    </div>

    {{-- Description --}}
    @if ($description)
        <p class="text-xs text-gray-500">{{ $description }}</p>
    @endif

    {{-- Erreur --}}
    @error($name)
        <p class="mt-1 text-xs text-red-600" role="alert">{{ $message }}</p>
    @enderror
</div>

{{-- Alpine logic --}}
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('asyncSelect', ({
            endpoint,
            labelKey = 'full_name',
            valueKey = 'id',
            initialValue = null
        }) => ({
            query: '',
            results: [],
            selectedId: initialValue || null,
            selectedItem: null,
            searching: false,
            labelKey,
            valueKey,

            async search() {
                if (this.query.length < 2) {
                    this.results = [];
                    return;
                }

                this.searching = true;
                try {
                    const res = await fetch(`${endpoint}?q=${encodeURIComponent(this.query)}`);
                    this.results = await res.json();
                    // this.renderItems();
                    console.log(this.results);
                } catch (err) {
                    console.error('Erreur asyncSelect:', err);
                } finally {
                    this.searching = false;
                }
            },

            select(item) {
                this.query = item[this.labelKey];
                this.selectedItem = item;
                this.selectedId = item[this.valueKey];
                this.results = [];
            },

            validateSelect() {
                if (!this.selectedId ||
                    !this.selectedItem ||
                    this.query !== this.selectedItem[this.labelKey]) {
                    this.query = '';
                    this.selectedItem = null;
                    this.selectedId = null;
                }
                this.results = [];
            },

            renderItem(el, item) {
                const slots = el.querySelectorAll('[data-key]');
                slots.forEach(slot => {
                    const key = slot.getAttribute('data-key');
                    if (item[key] !== undefined) {
                        slot.textContent = item[key];
                    }
                });
            },

            async init() {
                // Pré-remplissage (édition)
                if (this.selectedId) {
                    try {
                        const res = await fetch(`${endpoint}?id=${this.selectedId}`);
                        const item = await res.json();
                        if (item) {
                            this.query = item[this.labelKey];
                            this.selectedItem = item;
                        } else {
                            this.query = '';
                            this.selectedItem = null;
                            this.selectedId = null;
                        }
                    } catch (err) {
                        console.warn('Impossible de précharger la valeur', err);
                    }
                }
            }
        }));
    });
</script>
