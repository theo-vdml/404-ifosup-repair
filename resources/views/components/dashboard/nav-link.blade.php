@props([
    'active' => false,
    'href' => '#',
    'label' => 'Link',
    'icon' => null,
])

<a href="{{ $href ?? '#' }}"
    class="flex items-center px-4 py-3 space-x-3 transition-all duration-200 border border-transparent text-slate-700 hover:bg-purple-50/60 hover:text-slate-900 hover:border-purple-200/40 rounded-xl group">
    @if ($icon)
        {{ $icon }}
    @endif
    <span class="font-medium">{{ $label ?? 'Link' }}</span>
</a>
