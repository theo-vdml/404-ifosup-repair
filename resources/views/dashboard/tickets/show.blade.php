@php
    use App\Models\TicketPriority;
    use App\Models\TicketStatus;

    $priorities = TicketPriority::all();
    $statuses = TicketStatus::all();

@endphp

<x-dashboard-layout>
    <div
        class="flex flex-col gap-4 pb-8 mb-8 border-b border-slate-300/50 md:flex-row md:items-start md:justify-between">

        <div>
            <h1 class="text-4xl font-medium text-slate-900">{{ $ticket->title }} <span
                    class="font-normal text-slate-500">#{{ $ticket->id }}</span></h1>
            <p class="mt-2 text-slate-600">{{ $ticket->description }}</p>
        </div>

        <div>
            {{-- <span
                class="flex items-center gap-2 p-2 px-4 text-sm border rounded-full text-amber-500 bg-amber-500/20 border-amber-500 whitespace-nowrap">
                <x-heroicon-o-clock class="w-4 h-4" />
                {{ $ticket->status->label ?? $ticket->status->code }}
            </span> --}}
            <x-badge :label="$ticket->status->display_name" :color="$ticket->status->color" :icon="$ticket->status->icon" size="lg" />
        </div>
    </div>


    <div class="grid grid-cols-4">

        <div class="col-span-3 pr-6">

            <div class="mb-16 bg-white border rounded-lg border-slate-300/50">

                <div class="p-6 border-b border-slate-300/50">
                    <h2 class="text-lg font-bold text-slate-900">Historique</h2>
                    <p class="text-slate-600">Suivi des actions effectuées sur le ticket et des commentaires des
                        techniciens.</p>
                </div>

                <div>
                    @forelse ($ticket->timeline() as $event)
                        @switch($event['type'])
                            @case(App\Enums\TimelineEventType::Note)
                                <x-timeline.note :data="$event['data']" />
                            @break

                            @case(App\Enums\TimelineEventType::StatusChange)
                                <x-timeline.status :data="$event['data']" />
                            @break

                            @case(App\Enums\TimelineEventType::PriorityChange)
                                <x-timeline.priority :data="$event['data']" />
                            @break

                            @case(App\Enums\TimelineEventType::Assigned)
                                <x-timeline.assignment :data="$event['data']" />
                            @break

                            @case(App\Enums\TimelineEventType::Unassigned)
                                <x-timeline.unassignment :data="$event['data']" />
                            @break
                        @endswitch
                        @empty
                            <div class="flex flex-col items-center justify-center px-6 py-16">
                                <div class="flex items-center justify-center w-20 h-20 mb-4 rounded-full bg-slate-100">
                                    <x-heroicon-o-clipboard-document-list class="w-10 h-10 text-slate-400" />
                                </div>
                                <h3 class="mb-2 text-lg font-semibold text-slate-900">Aucun événement pour le moment</h3>
                                <p class="max-w-md mb-6 text-sm text-center text-slate-600">
                                    L'historique de ce ticket est vide. Les actions, modifications de statut et commentaires
                                    apparaîtront ici.
                                </p>
                                <div class="flex items-center gap-2 text-xs text-slate-500">
                                    <x-heroicon-o-light-bulb class="w-4 h-4" />
                                    <span>Commencez par ajouter un commentaire ci-dessous</span>
                                </div>
                            </div>
                        @endforelse

                    </div>

                    @if (!$ticket->status->marks_as_closed)
                        <!-- Add Comment Form -->
                        <div class="p-6 bg-slate-50">
                            <x-form method="POST" multipart action="{{ route('tickets.notes.store', $ticket) }}">
                                <x-form-field name="message"
                                    placeholder="Décrivez votre action ou ajoutez un commentaire..." type="textarea"
                                    label="Ajouter un commentaire" />
                                <x-attachment-input name="attachments" button-label="Joindre des fichiers"
                                    button-icon="heroicon-o-paper-clip" :multiple="true" />
                                <x-slot name="actions">
                                    <x-button type="submit" label="Publier" icon="heroicon-o-paper-airplane"
                                        variant="solid" />
                                </x-slot>
                            </x-form>
                        </div>
                    @else
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
                        <div class="border-t border-slate-300/50 {{ $colors['gradient'] }}">
                            <div class="p-8">
                                <div class="flex items-start gap-5">
                                    <!-- Icon -->
                                    <div class="flex-shrink-0">
                                        <div
                                            class="flex items-center justify-center w-12 h-12 rounded-full {{ $colors['bg'] }}">
                                            <x-heroicon-o-lock-closed class="w-6 h-6 {{ $colors['text'] }}" />
                                        </div>
                                    </div>

                                    <!-- Content -->
                                    <div class="flex-1">
                                        <h4 class="mb-2 text-base font-semibold text-slate-900">
                                            Ticket fermé ({{ $ticket->status->display_name }})
                                        </h4>
                                        <p class="mb-3 text-sm leading-relaxed text-slate-600">
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
                    @endif
                </div>

            </div>
            <div class="col-span-1 ">

                <!-- Assignés Section -->
                <div class="mb-4 bg-white border rounded-lg border-slate-300/50">
                    <div class="p-5 border-b rounded-t-lg border-slate-200 bg-gradient-to-r from-slate-50 to-white">
                        <h3 class="flex items-center gap-2 font-semibold text-slate-900">
                            <x-heroicon-o-users class="w-5 h-5 text-slate-600" />
                            Assignés
                        </h3>
                    </div>

                    <!-- Assigned Users List -->
                    <div class="p-5">
                        <div class="mb-4 space-y-3">
                            @forelse ($ticket->users as $user)
                                <div class="flex items-center gap-3">
                                    <div
                                        class="flex items-center justify-center flex-shrink-0 w-8 h-8 bg-blue-100 rounded-full">
                                        <x-heroicon-o-user class="w-4 h-4 text-blue-600" />
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-medium text-slate-900">{{ $user->name }}</p>
                                        <p class="text-xs text-blue-600">Technicien</p>
                                    </div>
                                    <form action="{{ route('tickets.unassign', [$ticket, $user]) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="transition-colors text-slate-600 hover:text-red-600">
                                            <x-heroicon-o-trash class="w-4 h-4" />
                                        </button>
                                    </form>
                                </div>
                            @empty
                                <div
                                    class="flex items-center gap-3 px-3 py-4 border border-dashed rounded-lg bg-slate-50 border-slate-200">
                                    <div
                                        class="flex items-center justify-center flex-shrink-0 w-8 h-8 bg-white rounded-full">
                                        <x-heroicon-o-user-plus class="w-4 h-4 text-slate-400" />
                                    </div>
                                    <p class="text-xs text-slate-500">
                                        Aucun technicien assigné
                                    </p>
                                </div>
                            @endforelse
                        </div>

                        <!-- Add User Form -->
                        <form action="{{ route('tickets.assign', $ticket) }}" method="POST"
                            class="flex items-start gap-2">
                            @csrf
                            <div class="flex-1">
                                <x-async-form-field name="user_id" route="{{ route('api.users.index') }}"
                                    placeholder="Ajouter un technicien..." size="fill">
                                    <div class="flex items-center space-x-3">
                                        <div
                                            class="flex items-center justify-center flex-shrink-0 w-8 h-8 rounded-full bg-slate-100">
                                            <x-heroicon-o-user class="w-5 h-5 text-gray-400" />
                                        </div>
                                        <div>
                                            <div class="font-medium text-slate-900" data-key="full_name"></div>
                                            <div class="text-xs text-slate-500" data-key="role"></div>
                                        </div>
                                    </div>
                                </x-async-form-field>
                            </div>
                            <button type="submit"
                                class="inline-flex items-center justify-center flex-shrink-0 text-white transition-colors bg-blue-600 rounded-md w-9 h-9 hover:bg-blue-700 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                <x-heroicon-o-plus class="w-5 h-5" />
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Informations Client Section -->
                <div class="mb-4 bg-white border rounded-lg border-slate-300/50">
                    <div class="p-5 border-b rounded-t-lg border-slate-200 bg-gradient-to-r from-slate-50 to-white">
                        <h3 class="flex items-center gap-2 font-semibold text-slate-900">
                            <x-heroicon-o-user-circle class="w-5 h-5 text-slate-600" />
                            Informations client
                        </h3>
                    </div>

                    <div class="p-5">
                        <!-- Customer Info -->
                        <div class="mb-4 space-y-3">
                            <div class="flex items-center gap-3">
                                <div
                                    class="flex items-center justify-center flex-shrink-0 w-8 h-8 rounded-full bg-slate-100">
                                    <x-heroicon-o-user class="w-4 h-4 text-slate-600" />
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-blue-600">{{ $ticket->customer->full_name }}</p>
                                    <p class="text-xs text-slate-600">{{ $ticket->customer->email }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- View Profile Button -->
                        <a href="{{ route('customers.show', $ticket->customer) }}"
                            class="inline-flex items-center justify-center w-full gap-2 px-3 py-2 text-sm transition-colors border rounded-md text-slate-600 border-slate-300 hover:bg-slate-50">
                            <x-heroicon-o-eye class="w-4 h-4" />
                            Voir le profil
                        </a>
                    </div>
                </div>

                <!-- Détails du Ticket Section -->
                <div class="bg-white border rounded-lg border-slate-300/50">
                    <div class="p-5 border-b rounded-t-lg border-slate-200 bg-gradient-to-r from-slate-50 to-white">
                        <h3 class="flex items-center gap-2 font-semibold text-slate-900">
                            <x-heroicon-o-cog-6-tooth class="w-5 h-5 text-slate-600" />
                            Détails du ticket
                        </h3>
                    </div>

                    <form action="{{ route('tickets.update', $ticket) }}" method="POST" class="p-5">
                        @csrf
                        @method('PATCH')

                        <div class="space-y-4">
                            <!-- Priority -->
                            <div>
                                <label for="priority_id"
                                    class="block mb-2 text-xs font-medium tracking-wider uppercase text-slate-700">
                                    Priorité
                                </label>
                                <div class="relative">
                                    <select id="priority_id" name="priority_id"
                                        class="w-full px-3 py-2.5 text-sm border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white transition-all appearance-none cursor-pointer hover:border-slate-400">
                                        @foreach ($priorities as $priority)
                                            <option value="{{ $priority->id }}"
                                                {{ $ticket->priority_id === $priority->id ? 'selected' : '' }}>
                                                {{ $priority->label ?? $priority->code }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div
                                        class="absolute inset-y-0 right-0 flex items-center px-3 pointer-events-none text-slate-600">
                                        <x-heroicon-o-chevron-down class="w-4 h-4" />
                                    </div>
                                </div>
                            </div>

                            <!-- Status -->
                            <div>
                                <label for="status_id"
                                    class="block mb-2 text-xs font-medium tracking-wider uppercase text-slate-700">
                                    Statut
                                </label>
                                <div class="relative">
                                    <select id="status_id" name="status_id"
                                        class="w-full px-3 py-2.5 text-sm border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white transition-all appearance-none cursor-pointer hover:border-slate-400">
                                        @foreach ($statuses as $status)
                                            <option value="{{ $status->id }}"
                                                {{ $ticket->status_id === $status->id ? 'selected' : '' }}>
                                                {{ $status->label ?? $status->code }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div
                                        class="absolute inset-y-0 right-0 flex items-center px-3 pointer-events-none text-slate-600">
                                        <x-heroicon-o-chevron-down class="w-4 h-4" />
                                    </div>
                                </div>
                            </div>

                            <!-- Update Button -->
                            <div class="pt-2">
                                <button type="submit"
                                    class="w-full inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors shadow-sm">
                                    <x-heroicon-o-check class="w-4 h-4" />
                                    Mettre à jour
                                </button>
                            </div>

                            <!-- Metadata -->
                            <div class="pt-4 border-t border-slate-200">
                                <div class="space-y-3">
                                    <div class="flex items-center justify-between">
                                        <span class="text-xs text-slate-500 flex items-center gap-1.5">
                                            <x-heroicon-o-calendar class="w-3.5 h-3.5" />
                                            Créé le
                                        </span>
                                        <span
                                            class="text-xs font-medium text-slate-900">{{ $ticket->created_at->format('d/m/Y H:i') }}</span>
                                    </div>

                                    <div class="flex items-center justify-between">
                                        <span class="text-xs text-slate-500 flex items-center gap-1.5">
                                            <x-heroicon-o-arrow-path class="w-3.5 h-3.5" />
                                            Dernière MAJ
                                        </span>
                                        <span
                                            class="text-xs font-medium text-slate-900">{{ $ticket->updated_at->diffForHumans() }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        </div>

    </x-dashboard-layout>
