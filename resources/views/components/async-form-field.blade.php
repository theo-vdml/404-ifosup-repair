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
            x-on:blur="validateSelect()" x-on:keydown.down.prevent="highlightNext()"
            x-on:keydown.up.prevent="highlightPrev()" x-on:keydown.enter="selectHighlighted"
            x-on:keydown.escape="closeDropdown()" autocomplete="off"
            {{ $attributes->merge(['placeholder' => 'Rechercher...']) }} role="combobox"
            :aria-expanded="results.length > 0 ? 'true' : 'false'"
            :aria-activedescendant="highlightedIndex >= 0 ? '{{ $name }}-option-' + highlightedIndex : ''"
            aria-invalid="{{ $errors->has($name) ? 'true' : 'false' }}"
            class="{{ $fieldBase }} h-10 {{ $errorClasses }} {{ $withIconPadding }}">

        {{-- Spinner --}}
        <div x-show="searching" class="absolute -translate-y-1/2 right-3 top-1/2">
            <x-heroicon-o-arrow-path class="w-4 h-4 text-gray-400 animate-spin" />
        </div>

        {{-- Dropdown --}}
        <template x-if="results.length > 0">
            <ul x-show="results.length > 0" x-transition x-ref="listbox" role="listbox"
                class="absolute z-10 w-full mt-1 overflow-auto bg-white border border-gray-200 rounded-md shadow-lg max-h-60">
                <template x-for="(item, index) in results" :key="item[valueKey]">
                    <li class="px-3 py-2 text-sm text-gray-700 transition-colors cursor-pointer"
                        :class="{ 'bg-gray-100': index === highlightedIndex }" x-on:mousedown.prevent="select(item)"
                        x-on:mouseenter="highlightedIndex = index" :data-item-index="index"
                        :id="'{{ $name }}-option-' + index" role="option"
                        :aria-selected="index === highlightedIndex ? 'true' : 'false'" x-init="renderItem($el, item)"
                        x-effect="if (index === highlightedIndex) { $el.scrollIntoView({ block: 'nearest', behavior: 'smooth' }); }">
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
            highlightedIndex: -1,
            labelKey,
            valueKey,

            async search() {
                if (this.query.length < 2) {
                    this.results = [];
                    this.highlightedIndex = -1;
                    return;
                }

                this.searching = true;
                try {
                    const res = await fetch(`${endpoint}?q=${encodeURIComponent(this.query)}`);
                    this.results = await res.json();
                    this.highlightedIndex = -1; // Don't auto-highlight on search
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
                this.highlightedIndex = -1;
            },

            highlightNext() {
                if (this.results.length === 0) return;
                this.highlightedIndex = (this.highlightedIndex + 1) % this.results.length;
            },

            highlightPrev() {
                if (this.results.length === 0) return;
                this.highlightedIndex = this.highlightedIndex <= 0 ?
                    this.results.length - 1 :
                    this.highlightedIndex - 1;
            },

            selectHighlighted(event) {
                if (this.highlightedIndex >= 0 && this.highlightedIndex < this.results.length) {
                    event.preventDefault();
                    this.select(this.results[this.highlightedIndex]);
                }
            },

            closeDropdown() {
                this.results = [];
                this.highlightedIndex = -1;
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
                this.highlightedIndex = -1;
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
