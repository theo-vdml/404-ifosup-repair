@props(['data'])

<div class="flex gap-3 px-4 py-4 border-b md:gap-4 md:px-6 md:py-5 border-slate-300/50">
    <div class="flex-shrink-0">
        <div class="flex items-center justify-center w-8 h-8 rounded-full md:w-9 md:h-9 bg-blue-500">
            <span class="text-xs font-semibold text-white md:text-sm">JD</span>
        </div>
    </div>
    <div class="flex-1 min-w-0">
        <div class="flex flex-col gap-1 mb-2 sm:flex-row sm:items-center sm:gap-2">
            <span class="text-sm font-semibold md:text-base text-slate-900">{{ $data->user?->name ?? 'System' }}</span>
            <span class="text-xs text-slate-400">{{ $data->created_at->diffForHumans() }}</span>
        </div>
        <div class="text-sm leading-relaxed break-words text-slate-700">
            {{ $data->message }}
        </div>

        {{-- Attachments --}}
        @if ($data->attachments->count() > 0)
            <div class="flex flex-wrap gap-1 mt-3">
                @foreach ($data->attachments as $attachment)
                    <a href="{{ route('attachments.download', $attachment->id) }}"
                        class="inline-flex items-center px-2 py-1 text-xs transition-colors border border-gray-200 rounded-full bg-gray-50 hover:bg-gray-100"
                        target="_blank" download="{{ $attachment->file_name }}">
                        <svg class="w-4 h-4 mr-1 text-gray-500" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                            </path>
                        </svg>

                        <span class="text-gray-700 truncate max-w-[80px] sm:max-w-[100px]">{{ $attachment->file_name }}</span>
                    </a>
                @endforeach
            </div>
        @endif
    </div>
</div>
