@props(['data'])

<div class="flex gap-4 px-6 py-5 border-b border-slate-300/50">
    <div class="flex-shrink-0">
        <div class="w-9 h-9 rounded-full bg-blue-500 flex items-center justify-center">
            <span class="text-white font-semibold text-sm">JD</span>
        </div>
    </div>
    <div class="flex-1">
        <div class="flex items-center gap-2 mb-2">
            <span class="font-semibold text-slate-900">{{ $data->user?->name ?? 'System' }}</span>
            {{-- <span
                class="inline-flex items-center gap-1 px-2 py-0.5 bg-green-50 text-green-700 rounded text-xs font-medium">
                <x-heroicon-o-check-circle class="w-3 h-3" />
                Intervention
            </span> --}}
            <span class="text-slate-400 text-xs">• {{ $data->created_at->diffForHumans() }}</span>
        </div>
        <div class="text-sm text-slate-700 leading-relaxed">
            {{ $data->message }}
        </div>
    </div>
</div>
