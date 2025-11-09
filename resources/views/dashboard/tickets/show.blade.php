@php
    use App\Models\TicketPriority;
    use App\Models\TicketStatus;

    $priorities = TicketPriority::all();
    $statuses = TicketStatus::all();

@endphp

<x-dashboard-layout>

    {{-- Ticket Header --}}

    <div
        class="flex flex-col gap-4 pb-6 mb-6 border-b md:pb-8 md:mb-8 border-slate-300/50 md:flex-row md:items-start md:justify-between">

        <div class="flex-1 min-w-0">
            <h1 class="text-2xl font-medium md:text-4xl text-slate-900">{{ $ticket->title }} <span
                    class="font-normal text-slate-500">#{{ $ticket->id }}</span></h1>
            <p class="mt-2 text-sm md:text-base text-slate-600">{{ $ticket->description }}</p>
        </div>

        <div class="flex-shrink-0">
            <x-badge :label="$ticket->status->display_name" :color="$ticket->status->color" :icon="$ticket->status->icon" size="lg" />
        </div>
    </div>


    {{-- Ticket Body --}}
    <div class="grid grid-cols-1 gap-6 lg:grid-cols-8">

        {{-- Left column (Timeline) --}}
        <div class="col-span-1 lg:col-span-5 xl:col-span-6 xl:pr-6">
            @include('dashboard.tickets.partials.timeline')
        </div>

        {{-- Right column (Informations) --}}
        <div class="col-span-1 space-y-4 lg:col-span-3 xl:col-span-2">

            @can('assignUser', $ticket)
                @include('dashboard.tickets.partials.assignments')
            @endcan

            <!-- Informations Client Section -->
            @include('dashboard.tickets.partials.client-info')

            @can('updateStatus', $ticket)
                @include('dashboard.tickets.partials.status-update')
            @endcan
        </div>
    </div>
</x-dashboard-layout>
