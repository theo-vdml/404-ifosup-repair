<?php

namespace App\Observers;

use App\Models\Ticket;
use Illuminate\Support\Facades\Auth;

/**
 * Observer for Ticket model events.
 *
 * Automatically tracks status and priority changes by creating history records
 * whenever a ticket is created or updated.
 */
class TicketObserver
{
    /**
     * Handle the Ticket "created" event.
     *
     * Creates initial history records for status and priority when a new ticket is created.
     *
     * @param Ticket $ticket The newly created ticket
     * @return void
     */
    public function created(Ticket $ticket): void
    {

        $ticket->statusHistory()->create([
            'status_id' => $ticket->status_id,
            'user_id' => Auth::id(),
        ]);

        $ticket->priorityHistory()->create([
            'priority_id' => $ticket->priority_id,
            'user_id' => Auth::id(),
        ]);
    }

    /**
     * Handle the Ticket "updated" event.
     *
     * Creates history records when status or priority changes are detected.
     * Only logs changes when the respective field has been modified.
     *
     * @param Ticket $ticket The updated ticket
     * @return void
     */
    public function updated(Ticket $ticket): void
    {
        // Log status change if it has been modified
        if ($ticket->isDirty('status_id')) {
            $ticket->statusHistory()->create([
                'status_id' => $ticket->status_id,
                'user_id' => Auth::id(),
            ]);
        }

        // Log priority change if it has been modified
        if ($ticket->isDirty('priority_id')) {
            $ticket->priorityHistory()->create([
                'priority_id' => $ticket->priority_id,
                'user_id' => Auth::id(),
            ]);
        }
    }
}
