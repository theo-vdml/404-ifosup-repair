@props([
    'label' => '',
    'color' => 'gray',
    'icon' => null,
    'size' => 'md',
])

@php

    $colors = match ($color) {
        'red' => 'bg-red-50 text-red-700 border-red-500/80',
        'orange' => 'bg-orange-50 text-orange-700 border-orange-500/80',
        'amber' => 'bg-amber-50 text-amber-700 border-amber-500/80',
        'yellow' => 'bg-yellow-50 text-yellow-700 border-yellow-500/80',
        'lime' => 'bg-lime-50 text-lime-700 border-lime-500/80',
        'green' => 'bg-green-50 text-green-700 border-green-500/80',
        'emerald' => 'bg-emerald-50 text-emerald-700 border-emerald-500/80',
        'teal' => 'bg-teal-50 text-teal-700 border-teal-500/80',
        'cyan' => 'bg-cyan-50 text-cyan-700 border-cyan-500/80',
        'sky' => 'bg-sky-50 text-sky-700 border-sky-500/80',
        'blue' => 'bg-blue-50 text-blue-700 border-blue-500/80',
        'indigo' => 'bg-indigo-50 text-indigo-700 border-indigo-500/80',
        'violet' => 'bg-violet-50 text-violet-700 border-violet-500/80',
        'purple' => 'bg-purple-50 text-purple-700 border-purple-500/80',
        'fuchsia' => 'bg-fuchsia-50 text-fuchsia-700 border-fuchsia-500/80',
        'pink' => 'bg-pink-50 text-pink-700 border-pink-500/80',
        'rose' => 'bg-rose-50 text-rose-700 border-rose-500/80',
        default => 'bg-gray-50 text-gray-700 border-gray-500/80',
    };

    $sizes = match ($size) {
        'sm' => 'px-2 py-0.5 text-xs border',
        'lg' => 'px-3 py-1 text-sm border-2',
        default => 'px-2.5 py-0.5 text-xs border',
    };

    $iconClasses = match ($size) {
        'sm' => 'w-3 h-3',
        'md' => 'w-3 h-3',
        'lg' => 'w-4 h-4',
        default => 'w-3 h-3',
    };

@endphp

<span
    class="inline-flex items-center rounded-full font-medium backdrop-blur-sm gap-1 {{ $sizes }} {{ $colors }}">
    @if ($icon)
        {{ svg($icon, $iconClasses . ' mt-0.4') }}
    @endif
    <span>{{ $label }}</span>
</span>
