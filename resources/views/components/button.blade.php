@props([
    'variant' => 'solid',
    'color' => 'primary',
    'size' => 'base', // new prop: sm, base, lg
    'disabled' => false,
    'label' => null,
    'icon' => null,
    'href' => null,
])

@php
    $baseClasses =
        'inline-flex items-center justify-center gap-2 rounded-lg font-medium transition-all focus:outline-none focus:ring-2 focus:ring-offset-1 backdrop-blur-sm';

    $colors = [
        'primary' => [
            'solid' => 'bg-purple-600 text-white hover:bg-purple-700 focus:ring-purple-500',
            'soft' =>
                'bg-purple-500/10 text-purple-700 border border-purple-500/30 hover:bg-purple-500/20 focus:ring-purple-300',
            'outline' => 'border border-purple-500 text-purple-600 hover:bg-purple-50 focus:ring-purple-300',
            'ghost' => 'text-purple-600 hover:bg-purple-50 focus:ring-purple-300',
        ],
        'secondary' => [
            'solid' => 'bg-slate-800 text-white hover:bg-slate-700 focus:ring-slate-500',
            'soft' => 'bg-slate-50 text-slate-700 border border-slate-400 hover:bg-slate-100 focus:ring-slate-300',
            'outline' => 'border border-slate-400 text-slate-700 hover:bg-slate-50 focus:ring-slate-300',
            'ghost' => 'text-slate-700 hover:bg-slate-50 focus:ring-slate-300',
        ],
        'danger' => [
            'solid' => 'bg-red-600 text-white hover:bg-red-700 focus:ring-red-500',
            'soft' => 'bg-red-500/10 text-red-700 border border-red-500/30 hover:bg-red-500/20 focus:ring-red-300',
            'outline' => 'border border-red-500 text-red-600 hover:bg-red-50 focus:ring-red-300',
            'ghost' => 'text-red-600 hover:bg-red-50 focus:ring-red-300',
        ],
    ];

    $sizeClasses = [
        'xs' => 'px-2 py-1 text-xs',
        'sm' => 'px-3 py-1.5 text-sm',
        'base' => 'px-4 py-2 text-sm',
        'lg' => 'px-6 py-3 text-base',
    ];

    $buttonSizeClasses = [
        'xs' => 'w-4 h-4',
        'sm' => 'w-4 h-4',
        'base' => 'w-5 h-5',
        'lg' => 'w-6 h-6',
    ];

    $variantClass = $colors[$color][$variant] ?? $colors['primary']['solid'];
    $sizeClass = $sizeClasses[$size] ?? $sizeClasses['base'];
    $disabledClasses = $disabled ? 'opacity-50 cursor-not-allowed pointer-events-none' : '';

    $classes = "{$baseClasses} {$variantClass} {$sizeClass} {$disabledClasses}";
@endphp

@if ($href)
    <a href="{{ $disabled ? '#' : $href }}" {{ $attributes->merge(['class' => $classes]) }}>
        @if ($icon)
            {{ svg($icon, $buttonSizeClasses[$size] ?? $buttonSizeClasses['base']) }}
        @endif
        @if ($label)
            <span>{{ $label }}</span>
        @endif
    </a>
@else
    <button {{ $attributes->merge(['class' => $classes]) }} @disabled($disabled)>
        @if ($icon)
            {{ svg($icon, $buttonSizeClasses[$size] ?? $buttonSizeClasses['base']) }}
        @endif
        @if ($label)
            <span>{{ $label }}</span>
        @endif
    </button>
@endif
