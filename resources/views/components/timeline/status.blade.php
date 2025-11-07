@props(['data'])

<div class="flex gap-3 px-4 py-3 border-b md:px-6 border-slate-300/50">
    <div class="flex-shrink-0">
        <div class="flex items-center justify-center w-6 h-6 rounded-full bg-amber-50">
            <x-heroicon-o-arrow-path class="w-3.5 h-3.5 text-amber-500" />
        </div>
    </div>
    <div class="flex items-center flex-1 min-w-0">
        <div class="flex flex-wrap items-center gap-1 text-sm text-slate-600">
            <span class="font-semibold text-slate-900">{{ $data->user?->name ?? 'System' }}</span>
            <span>a changé le statut du ticket.</span>
            <x-badge :label="$data->status->display_name" :color="$data->status->color" :icon="$data->status->icon" size="sm" />
            <span class="text-slate-400 text-xs ml-1.5">{{ $data->created_at->diffForHumans() }}</span>
        </div>
    </div>
</div>
