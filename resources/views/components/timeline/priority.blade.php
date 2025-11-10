@props(['data'])

<div class="flex gap-3 px-4 py-3 border-b md:px-6 border-slate-300/50">
    <div class="flex-shrink-0">
        <div class="flex items-center justify-center w-6 h-6 rounded-full bg-purple-50">
            <x-heroicon-o-flag class="w-3.5 h-3.5 text-purple-500" />
        </div>
    </div>
    <div class="flex items-center flex-1 min-w-0">
        <div class="text-sm break-words text-slate-600">
            <span class="font-medium text-slate-800">{{ $data->user?->name ?? 'System' }}</span>
            a changé la priorité du ticket en <span class="font-medium text-slate-800">{{ $data->priority->code }}</span>
            <span class="text-slate-400 text-xs ml-1.5">{{ $data->created_at->diffForHumans() }}</span>
        </div>
    </div>
</div>
