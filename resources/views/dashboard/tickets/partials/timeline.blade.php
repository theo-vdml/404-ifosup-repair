<div class="mb-8 bg-white border rounded-lg xl:mb-16 border-slate-300/50">

    <div class="p-4 border-b md:p-6 border-slate-300/50">
        <h2 class="text-base font-bold md:text-lg text-slate-900">Historique</h2>
        <p class="text-sm md:text-base text-slate-600">Suivi des actions effectuées sur le ticket et des
            commentaires des
            techniciens.</p>
    </div>

    @forelse ($ticket->timeline() as $event)
        <div>
            @if ($event['type'] === App\Enums\TimelineEventType::Note)
                <x-timeline.note :data="$event['data']" />
            @elseif($event['type'] === App\Enums\TimelineEventType::StatusChange)
                <x-timeline.status :data="$event['data']" />
            @elseif($event['type'] === App\Enums\TimelineEventType::PriorityChange)
                <x-timeline.priority :data="$event['data']" />
            @elseif($event['type'] === App\Enums\TimelineEventType::Assigned)
                <x-timeline.assignment :data="$event['data']" />
            @elseif($event['type'] === App\Enums\TimelineEventType::Unassigned)
                <x-timeline.unassignment :data="$event['data']" />
            @endif
        </div>
    @empty
        <x-timeline.empty />
    @endforelse

    @if (!$ticket->status->marks_as_closed)
        <x-timeline.add-comment :ticket="$ticket" />
    @else
        <x-timeline.closed-notice :ticket="$ticket" />
    @endif

</div>
