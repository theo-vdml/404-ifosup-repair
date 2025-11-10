@props([
    'name' => 'files',
    'label' => null,
    'buttonLabel' => null,
    'buttonIcon' => null,
    'description' => null,
    'size' => 'fill', // fill | half
    'multiple' => true,
    'accept' => null,
])

@php
    $colSpan = $size === 'half' ? 'lg:col-span-1' : 'lg:col-span-2';
    $hasError = $errors->has($name);
@endphp

<div class="{{ $colSpan }} space-y-2" x-data="fileAttachments()">
    {{-- Label --}}
    @if ($label)
        <label for="{{ $name }}" class="block text-sm font-semibold text-gray-700">
            {{ $label }}
        </label>
    @endif

    {{-- Input wrapper --}}
    <div class="relative">
        {{-- Hidden accumulator input (holds all files for submission) --}}
        <input type="file" x-ref="accumulatorInput" {{ $multiple ? 'multiple' : '' }}
            name="{{ $name }}{{ $multiple ? '[]' : '' }}" style="display: none;">

        {{-- Hidden selector input (for new selections) --}}
        <input type="file" x-ref="selectorInput" x-on:change="addFiles($event)" {{ $multiple ? 'multiple' : '' }}
            {{ $accept ? 'accept="' . $accept . '"' : '' }} style="display: none;">

        {{-- Files Container --}}
        <div class="mt-3 flex flex-wrap gap-2">

            <x-button variant="soft" size="sm" type="button" :label="$buttonLabel ?? 'Upload file'" :icon="$buttonIcon ?? 'heroicon-o-plus'"
                class="rounded-full" @click="$refs.selectorInput.click()" />

            {{-- File Pills --}}
            <template x-for="(file, index) in files" :key="index">
                <div class="inline-flex items-center bg-gray-100 rounded-full px-3 py-1 border border-gray-200">
                    <template x-if="file.type.startsWith('image/')">
                        <img :src="URL.createObjectURL(file)" class="w-5 h-5 object-cover rounded mr-2 flex-shrink-0"
                            alt="Preview">
                    </template>
                    <template x-if="!file.type.startsWith('image/')">
                        <svg class="w-5 h-5 text-gray-500 mr-2 flex-shrink-0" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                            </path>
                        </svg>
                    </template>
                    <span class="text-sm text-gray-900 mr-1 truncate max-w-[120px]" x-text="file.name"></span>
                    <span class="text-xs text-gray-500 mr-2" x-text="'(' + formatFileSize(file.size) + ')'"></span>
                    <button @click="removeFile(index)" type="button"
                        class="text-gray-500 hover:text-red-500 ml-1 flex-shrink-0">
                        ×
                    </button>
                </div>
            </template>
        </div>
    </div>

    {{-- Description --}}
    @if ($description)
        <p class="text-xs text-gray-500">{{ $description }}</p>
    @endif

    {{-- Error --}}
    @error($name)
        <p class="mt-1 text-xs text-red-600" role="alert">{{ $message }}</p>
    @enderror
</div>

{{-- Alpine logic --}}
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('fileAttachments', () => ({
            files: [],

            addFiles(event) {
                const newFiles = Array.from(event.target.files);
                this.files.push(...newFiles);
                this.updateAccumulator();
                event.target.value = ''; // Reset selector input
            },

            removeFile(index) {
                this.files.splice(index, 1);
                this.updateAccumulator();
            },

            updateAccumulator() {
                const dt = new DataTransfer();
                this.files.forEach(file => dt.items.add(file));
                this.$refs.accumulatorInput.files = dt.files;
            },

            formatFileSize(bytes) {
                if (bytes === 0) return '0 Bytes';
                const k = 1024;
                const sizes = ['Bytes', 'KB', 'MB', 'GB'];
                const i = Math.floor(Math.log(bytes) / Math.log(k));
                return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
            }
        }));
    });
</script>
