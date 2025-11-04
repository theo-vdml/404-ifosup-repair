@props(['data'])

<div class="flex gap-3 px-6 py-3 border-b border-slate-300/50">
    <div class="flex-shrink-0">
        <div class="w-6 h-6 rounded-full bg-amber-50 flex items-center justify-center">
            <x-heroicon-o-arrow-path class="w-3.5 h-3.5 text-amber-500" />
        </div>
    </div>
    <div class="flex-1 flex items-center">
        <div class="text-sm text-slate-600">
            <span class="font-medium text-slate-800">{{ $data->user?->name ?? 'System' }}</span>
            a changé le statut du ticket en <span class="font-medium text-slate-800">{{ $data->status->code }}</span>
            <span class="text-slate-400 text-xs ml-1.5">• {{ $data->created_at->diffForHumans() }}</span>
        </div>
    </div>
</div>
