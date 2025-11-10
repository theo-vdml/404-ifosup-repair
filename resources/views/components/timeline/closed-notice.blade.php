@props(['ticket'])

@php
    $colors = match ($ticket->status->color) {
        'red' => [
            'gradient' => 'bg-gradient-to-t from-red-50/90 to-white',
            'bg' => 'bg-red-100',
            'text' => 'text-red-600',
        ],
        'orange' => [
            'gradient' => 'bg-gradient-to-t from-orange-50/90 to-white',
            'bg' => 'bg-orange-100',
            'text' => 'text-orange-600',
        ],
        'amber' => [
            'gradient' => 'bg-gradient-to-t from-amber-50/90 to-white',
            'bg' => 'bg-amber-100',
            'text' => 'text-amber-600',
        ],
        'yellow' => [
            'gradient' => 'bg-gradient-to-t from-yellow-50/90 to-white',
            'bg' => 'bg-yellow-100',
            'text' => 'text-yellow-600',
        ],
        'lime' => [
            'gradient' => 'bg-gradient-to-t from-lime-50/90 to-white',
            'bg' => 'bg-lime-100',
            'text' => 'text-lime-600',
        ],
        'green' => [
            'gradient' => 'bg-gradient-to-t from-green-50/90 to-white',
            'bg' => 'bg-green-100',
            'text' => 'text-green-600',
        ],
        'emerald' => [
            'gradient' => 'bg-gradient-to-t from-emerald-50/90 to-white',
            'bg' => 'bg-emerald-100',
            'text' => 'text-emerald-600',
        ],
        'teal' => [
            'gradient' => 'bg-gradient-to-t from-teal-50/90 to-white',
            'bg' => 'bg-teal-100',
            'text' => 'text-teal-600',
        ],
        'cyan' => [
            'gradient' => 'bg-gradient-to-t from-cyan-50/90 to-white',
            'bg' => 'bg-cyan-100',
            'text' => 'text-cyan-600',
        ],
        'sky' => [
            'gradient' => 'bg-gradient-to-t from-sky-50/90 to-white',
            'bg' => 'bg-sky-100',
            'text' => 'text-sky-600',
        ],
        'blue' => [
            'gradient' => 'bg-gradient-to-t from-blue-50/90 to-white',
            'bg' => 'bg-blue-100',
            'text' => 'text-blue-600',
        ],
        'indigo' => [
            'gradient' => 'bg-gradient-to-t from-indigo-50/90 to-white',
            'bg' => 'bg-indigo-100',
            'text' => 'text-indigo-600',
        ],
        'violet' => [
            'gradient' => 'bg-gradient-to-t from-violet-50/90 to-white',
            'bg' => 'bg-violet-100',
            'text' => 'text-violet-600',
        ],
        'purple' => [
            'gradient' => 'bg-gradient-to-t from-purple-50/90 to-white',
            'bg' => 'bg-purple-100',
            'text' => 'text-purple-600',
        ],
        'fuchsia' => [
            'gradient' => 'bg-gradient-to-t from-fuchsia-50/90 to-white',
            'bg' => 'bg-fuchsia-100',
            'text' => 'text-fuchsia-600',
        ],
        'pink' => [
            'gradient' => 'bg-gradient-to-t from-pink-50/90 to-white',
            'bg' => 'bg-pink-100',
            'text' => 'text-pink-600',
        ],
        'rose' => [
            'gradient' => 'bg-gradient-to-t from-rose-50/90 to-white',
            'bg' => 'bg-rose-100',
            'text' => 'text-rose-600',
        ],
        default => [
            'gradient' => 'bg-gradient-to-t from-gray-50/90 to-white',
            'bg' => 'bg-gray-100',
            'text' => 'text-gray-600',
        ],
    };
@endphp

<div class="border-b border-slate-300/50 {{ $colors['gradient'] }}">
    <div class="p-4 md:p-8">
        <div class="flex items-start gap-3 md:gap-5">
            <!-- Icon -->
            <div class="flex-shrink-0">
                <div class="flex items-center justify-center w-10 h-10 rounded-full md:w-12 md:h-12 {{ $colors['bg'] }}">
                    <x-heroicon-o-lock-closed class="w-5 h-5 md:w-6 md:h-6 {{ $colors['text'] }}" />
                </div>
            </div>

            <!-- Content -->
            <div class="flex-1 min-w-0">
                <h4 class="mb-2 text-sm font-semibold md:text-base text-slate-900">
                    Ticket fermé ({{ $ticket->status->display_name }})
                </h4>
                <p class="mb-3 text-xs leading-relaxed md:text-sm text-slate-600">
                    Ce ticket a été marqué comme fermé. Les commentaires et modifications ne sont
                    plus autorisés sur ce ticket.
                </p>
                <p class="text-xs text-slate-500">
                    Pour ajouter des informations, veuillez rouvrir le ticket depuis les détails ou
                    créer un nouveau ticket.
                </p>
            </div>
        </div>
    </div>
</div>
