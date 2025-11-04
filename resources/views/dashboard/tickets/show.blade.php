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
                    class="text-slate-500 font-normal">#{{ $ticket->id }}</span></h1>
            <p class="mt-2 text-slate-600">{{ $ticket->description }}</p>
        </div>

        <div>
            <span
                class="text-amber-500 bg-amber-500/20 border border-amber-500 rounded-full p-2 px-4 flex gap-2 items-center text-sm whitespace-nowrap">
                <x-heroicon-o-clock class="w-4 h-4" />
                {{ $ticket->status->label ?? $ticket->status->code }}
            </span>
        </div>
    </div>


    <div class="grid grid-cols-4">

        <div class="col-span-3 pr-6">

            <div class="bg-white border-slate-300/50 border rounded-lg mb-16">

                <div class="p-6 border-b border-slate-300/50">
                    <h2 class="font-bold text-lg text-slate-900">Historique</h2>
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
                            <div class="flex flex-col items-center justify-center py-16 px-6">
                                <div class="w-20 h-20 bg-slate-100 rounded-full flex items-center justify-center mb-4">
                                    <x-heroicon-o-clipboard-document-list class="w-10 h-10 text-slate-400" />
                                </div>
                                <h3 class="text-lg font-semibold text-slate-900 mb-2">Aucun événement pour le moment</h3>
                                <p class="text-sm text-slate-600 text-center max-w-md mb-6">
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

                            <h3 class="font-semibold text-slate-900 mb-4">Ajouter un commentaire</h3>

                            <form action="{{ route('tickets.notes.store', $ticket) }}" method="POST" class="space-y-4">
                                @csrf

                                <!-- Type Selection -->
                                {{-- <div>
                                <label for="comment-type" class="block text-sm font-medium text-slate-700 mb-2">
                                    Type d'action
                                </label>
                                <select id="comment-type" name="type"
                                    class="w-full px-3 py-2 text-sm border border-slate-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white transition-colors">
                                    <option value="diagnostic">Diagnostic</option>
                                    <option value="intervention">Intervention</option>
                                    <option value="commentaire">Commentaire</option>
                                </select>
                            </div> --}}

                                <!-- Textarea -->
                                <div>
                                    <label for="comment-text" class="block text-sm font-medium text-slate-700 mb-2">
                                        Message
                                    </label>
                                    <textarea id="comment-text" name="comment" rows="4"
                                        placeholder="Décrivez votre action ou ajoutez un commentaire..."
                                        class="w-full px-3 py-2 text-sm border border-slate-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 resize-none transition-colors"></textarea>
                                </div>

                                <!-- Actions -->
                                <div class="flex items-center justify-between pt-2">
                                    <button type="button"
                                        class="inline-flex items-center gap-2 px-3 py-2 text-sm text-slate-600 border border-slate-300 hover:bg-slate-50 rounded-md transition-colors">
                                        <x-heroicon-o-paper-clip class="w-4 h-4" />
                                        Joindre un fichier
                                    </button>

                                    <div class="flex gap-2">
                                        <button type="submit" name="action" value="publish_and_close"
                                            class="inline-flex items-center gap-2 px-4 py-2 bg-slate-600 text-white text-sm font-medium rounded-md hover:bg-slate-700 focus:ring-2 focus:ring-slate-500 focus:ring-offset-2 transition-colors">
                                            <x-heroicon-o-check-circle class="w-4 h-4" />
                                            Publier et fermer
                                        </button>

                                        <button type="submit" name="action" value="publish"
                                            class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-md hover:bg-blue-700 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors">
                                            <x-heroicon-o-paper-airplane class="w-4 h-4" />
                                            Publier
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    @else
                        <div class="border-t border-slate-300/50 bg-gradient-to-b from-emerald-50/50 to-white">
                            <div class="p-8">
                                <div class="flex items-start gap-5">
                                    <!-- Icon -->
                                    <div class="flex-shrink-0">
                                        <div class="w-12 h-12 rounded-full bg-emerald-100 flex items-center justify-center">
                                            <x-heroicon-o-lock-closed class="w-6 h-6 text-emerald-600" />
                                        </div>
                                    </div>

                                    <!-- Content -->
                                    <div class="flex-1">
                                        <h4 class="text-base font-semibold text-slate-900 mb-2">
                                            Ticket fermé
                                        </h4>
                                        <p class="text-sm text-slate-600 leading-relaxed mb-3">
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
                <div class="bg-white border border-slate-300/50 rounded-lg mb-4">
                    <div class="p-5 border-b border-slate-200 bg-gradient-to-r from-slate-50 to-white rounded-t-lg">
                        <h3 class="font-semibold text-slate-900 flex items-center gap-2">
                            <x-heroicon-o-users class="w-5 h-5 text-slate-600" />
                            Assignés
                        </h3>
                    </div>

                    <!-- Assigned Users List -->
                    <div class="p-5">
                        <div class="space-y-3 mb-4">
                            @forelse ($ticket->users as $user)
                                <div class="flex items-center gap-3">
                                    <div
                                        class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center flex-shrink-0">
                                        <x-heroicon-o-user class="w-4 h-4 text-blue-600" />
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-medium text-slate-900">{{ $user->name }}</p>
                                        <p class="text-xs text-blue-600">Technicien</p>
                                    </div>
                                    <form action="{{ route('tickets.unassign', [$ticket, $user]) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-slate-600 hover:text-red-600 transition-colors">
                                            <x-heroicon-o-trash class="w-4 h-4" />
                                        </button>
                                    </form>
                                </div>
                            @empty
                                <div
                                    class="flex items-center gap-3 py-4 px-3 bg-slate-50 rounded-lg border border-dashed border-slate-200">
                                    <div
                                        class="w-8 h-8 bg-white rounded-full flex items-center justify-center flex-shrink-0">
                                        <x-heroicon-o-user-plus class="w-4 h-4 text-slate-400" />
                                    </div>
                                    <p class="text-xs text-slate-500">
                                        Aucun technicien assigné
                                    </p>
                                </div>
                            @endforelse
                        </div>

                        <!-- Add User Form -->
                        <form action="{{ route('tickets.assign', $ticket) }}" method="POST" class="flex items-start gap-2">
                            @csrf
                            <div class="flex-1">
                                <x-async-form-field name="user_id" route="{{ route('api.users.index') }}"
                                    placeholder="Ajouter un technicien..." size="fill">
                                    <div class="flex items-center space-x-3">
                                        <div
                                            class="flex-shrink-0 w-8 h-8 bg-slate-100 rounded-full flex items-center justify-center">
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
                                class="flex-shrink-0 w-9 h-9 inline-flex items-center justify-center bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors">
                                <x-heroicon-o-plus class="w-5 h-5" />
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Informations Client Section -->
                <div class="bg-white border border-slate-300/50 rounded-lg mb-4">
                    <div class="p-5 border-b border-slate-200 bg-gradient-to-r from-slate-50 to-white  rounded-t-lg">
                        <h3 class="font-semibold text-slate-900 flex items-center gap-2">
                            <x-heroicon-o-user-circle class="w-5 h-5 text-slate-600" />
                            Informations client
                        </h3>
                    </div>

                    <div class="p-5">
                        <!-- Customer Info -->
                        <div class="space-y-3 mb-4">
                            <div class="flex items-center gap-3">
                                <div
                                    class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center flex-shrink-0">
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
                            class="w-full inline-flex items-center justify-center gap-2 px-3 py-2 text-sm text-slate-600 border border-slate-300 hover:bg-slate-50 rounded-md transition-colors">
                            <x-heroicon-o-eye class="w-4 h-4" />
                            Voir le profil
                        </a>
                    </div>
                </div>

                <!-- Détails du Ticket Section -->
                <div class="bg-white border border-slate-300/50 rounded-lg">
                    <div class="p-5 border-b border-slate-200 bg-gradient-to-r from-slate-50 to-white  rounded-t-lg">
                        <h3 class="font-semibold text-slate-900 flex items-center gap-2">
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
                                    class="block text-xs font-medium text-slate-700 mb-2 uppercase tracking-wider">
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
                                        class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-slate-600">
                                        <x-heroicon-o-chevron-down class="w-4 h-4" />
                                    </div>
                                </div>
                            </div>

                            <!-- Status -->
                            <div>
                                <label for="status_id"
                                    class="block text-xs font-medium text-slate-700 mb-2 uppercase tracking-wider">
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
                                        class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-slate-600">
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
