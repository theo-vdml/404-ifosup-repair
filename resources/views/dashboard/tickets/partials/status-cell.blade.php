<div>
    @if ($row->is_closed)
        <span
            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-50 text-emerald-700 border border-emerald-200/50 backdrop-blur-sm gap-2">
            <x-heroicon-o-check class="w-3 h-3" />
            Résolu
        </span>
    @else
        <span
            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-amber-50 text-amber-700 border border-amber-200/50 backdrop-blur-sm gap-2">
            <x-heroicon-o-clock class="w-3 h-3" />
            En cours
        </span>
    @endif
</div>
