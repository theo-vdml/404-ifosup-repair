<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\TicketPriority;
use App\Models\TicketStatus;
use App\Models\TicketUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Gate::authorize('viewAny', Ticket::class);

        $tickets = Ticket::with(['customer', 'status', 'priority'])->sorted('created_at', 'desc')->filtered()->paginate(10)->withQueryString();

        return view('dashboard.tickets.index', compact('tickets'));
    }

    /**
     * Display tickets assigned to the current user with open status.
     */
    public function my()
    {
        Gate::authorize('viewAny', Ticket::class);

        $tickets = Ticket::with(['customer', 'status', 'priority'])
            ->whereRelation('users', 'user_id', Auth::id())
            ->whereHas('status', fn($q) => $q->where('code', 'open'))
            ->sorted('created_at', 'desc')
            ->filtered()
            ->paginate(10)
            ->withQueryString();

        return view('dashboard.tickets.my-tickets', compact('tickets'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Gate::authorize('create', Ticket::class);

        return view('dashboard.tickets.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Gate::authorize('create', Ticket::class);

        $data = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $data['status_id'] = TicketStatus::open()->id;
        $data['priority_id'] = TicketPriority::low()->id;

        $ticket = Ticket::create($data);

        return redirect()->route('tickets.show', $ticket);
    }

    /**
     * Display the specified resource.
     */
    public function show(Ticket $ticket)
    {
        Gate::authorize('view', $ticket);

        return view('dashboard.tickets.show', compact('ticket'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Ticket $ticket)
    {
        Gate::authorize('update', $ticket);

        return view('dashboard.tickets.edit', compact('ticket'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Ticket $ticket)
    {
        $data = $request->validate([
            'title' => 'sometimes|string|max:255',
            'description' => 'sometimes|string',
            'status_id' => 'sometimes|exists:ticket_statuses,id',
            'priority_id' => 'sometimes|exists:ticket_priorities,id',
        ]);

        // Check permissions based on what is being updated
        if (isset($data['status_id'])) {
            Gate::authorize('updateStatus', $ticket);
        }

        if (isset($data['priority_id'])) {
            Gate::authorize('updatePriority', $ticket);
        }

        // If only title/description are being updated, check general update permission
        if (!isset($data['status_id']) && !isset($data['priority_id'])) {
            Gate::authorize('update', $ticket);
        }

        $ticket->update($data);

        return redirect()->route('tickets.show', $ticket);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function assignUser(Request $request, Ticket $ticket)
    {
        Gate::authorize('assignUser', $ticket);

        $data = $request->validate([
            'user_id' => 'exists:users,id',
        ]);

        TicketUser::firstOrCreate([
            'ticket_id' => $ticket->id,
            'user_id' => $data['user_id'],
        ]);

        return redirect()->route('tickets.show', $ticket);
    }

    public function unassignUser(Request $request, Ticket $ticket, User $user)
    {
        Gate::authorize('assignUser', $ticket);

        $relation = TicketUser::where('ticket_id', $ticket->id)
            ->where('user_id', $user->id)->first();

        if ($relation) {
            $relation->delete();
        }

        return redirect()->route('tickets.show', $ticket);
    }

    /**
     * Store a new note for the ticket.
     */
    public function storeNote(Request $request, Ticket $ticket)
    {
        Gate::authorize('addNote', $ticket);

        $data = $request->validate([
            'message' => 'required|string',
            'attachments' => 'nullable|array',
            'attachments.*' => 'file',
        ]);

        // Create the note
        $note = $ticket->notes()->create([
            'user_id' => Auth::id(),
            'message' => $data['message'],
        ]);

        if ($request->hasFile('attachments')) {
            $note->attachFiles($request->file('attachments'));
        }

        return redirect()->route('tickets.show', $ticket)->with('success', 'Commentaire ajouté avec succès.');
    }
}
