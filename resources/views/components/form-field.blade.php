@props([
    'label' => null,
    'description' => null,
    'type' => 'text',
    'icon' => null,
    'size' => 'fill', // fill | half
    'name',
    'options' => null, // for select (optional)
    'value' => null, // default value (optional)
    'defaultOption' => null, // for select: ['label' => 'All', 'value' => '']
    'placeholder' => null, // for input placeholder
])

@php
    // Column span based on size: fill -> span 2 on md, half -> span 1
    $colSpan = $size === 'half' ? 'lg:col-span-1' : 'lg:col-span-2';

    // Base visual tokens (modern, subtle)
    $fieldBase =
        'w-full rounded-md border bg-white/70 backdrop-blur-sm px-3 py-2 text-sm transition-shadow transition-colors shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-0';
    $inputSize = $type === 'textarea' ? 'min-h-[120px] resize-y' : 'h-10';
    $hasError = isset($name) && $errors->has($name);
    $errorClasses = $hasError ? 'border-red-500 focus:ring-red-300' : 'border-gray-200 focus:ring-indigo-300';
    $withIconPadding = $icon ? 'pl-10' : '';
    $iconPositionClasses = $type === 'textarea' ? 'top-2.5 left-3' : '-translate-y-1/2 left-3 top-1/2';
@endphp

<div class="{{ $colSpan }} space-y-2">
    @if ($label)
        <label for="{{ $name }}" class="block text-sm font-semibold text-gray-700">
            {{ $label }}
        </label>
    @endif

    <div class="relative">
        @if ($type === 'textarea')
            <textarea id="{{ $name }}" name="{{ $name }}" aria-invalid="{{ $hasError ? 'true' : 'false' }}"
                {{ $attributes->merge(['class' => "{$fieldBase} {$inputSize} {$errorClasses} {$withIconPadding}", 'placeholder' => $placeholder]) }}>{{ old($name, $value) }}</textarea>
        @elseif ($type === 'select')
            <select id="{{ $name }}" name="{{ $name }}" aria-invalid="{{ $hasError ? 'true' : 'false' }}"
                {{ $attributes->merge(['class' => "{$fieldBase} {$inputSize} {$errorClasses} {$withIconPadding}"]) }}>
                @if ($defaultOption)
                    <option value="{{ $defaultOption['value'] ?? '' }}"
                        {{ old($name, $value) == ($defaultOption['value'] ?? '') ? 'selected' : '' }}>
                        {{ $defaultOption['label'] ?? 'All' }}
                    </option>
                @endif
                @if (is_array($options))
                    @foreach ($options as $val => $labelOption)
                        <option value="{{ $val }}" {{ old($name, $value) == $val ? 'selected' : '' }}>
                            {{ $labelOption }}</option>
                    @endforeach
                @endif
            </select>
        @else
            <input id="{{ $name }}" name="{{ $name }}" type="{{ $type }}"
                value="{{ old($name, $value) }}" aria-invalid="{{ $hasError ? 'true' : 'false' }}"
                {{ $attributes->merge(['class' => "{$fieldBase} {$inputSize} {$errorClasses} {$withIconPadding}", 'placeholder' => $placeholder]) }} />
        @endif

        @if ($icon)
            <div class="absolute text-gray-400 pointer-events-none {{ $iconPositionClasses }}">
                {{ svg($icon, 'w-5 h-5') }}
            </div>
        @endif
    </div>

    @if ($description)
        <p class="mb-1 text-xs text-gray-500">{{ $description }}</p>
    @endif

    @error($name)
        <p class="mt-1 text-xs text-red-600" role="alert">{{ $message }}</p>
    @enderror
</div>
