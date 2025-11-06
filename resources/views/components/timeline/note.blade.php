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
            <span class="text-slate-400 text-xs">• {{ $data->created_at->diffForHumans() }}</span>
        </div>
        <div class="text-sm text-slate-700 leading-relaxed">
            {{ $data->message }}
        </div>

        {{-- Attachments --}}
        @if ($data->attachments->count() > 0)
            <div class="mt-3 flex flex-wrap gap-1">
                @foreach ($data->attachments as $attachment)
                    <a href="{{ route('attachments.download', $attachment->id) }}"
                        class="inline-flex items-center bg-gray-50 hover:bg-gray-100 rounded-full px-2 py-1 border border-gray-200 text-xs transition-colors"
                        target="_blank" download="{{ $attachment->file_name }}">
                        <svg class="w-4 h-4 text-gray-500 mr-1" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                            </path>
                        </svg>

                        <span class="text-gray-700 truncate max-w-[100px]">{{ $attachment->file_name }}</span>
                    </a>
                @endforeach
            </div>
        @endif
    </div>
</div>
