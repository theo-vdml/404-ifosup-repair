<?php

namespace App\Models;

use App\Enums\TimelineEventType;
use App\Models\Traits\Filterable;
use App\Models\Traits\Sortable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;
    use Sortable, Filterable;

    protected $fillable = [
        'title',
        'description',
        'customer_id',
        'status_id',
        'priority_id',
    ];

    protected $multiColumnSorts = [
        'customer.full_name' => ['customer.first_name', 'customer.last_name'],
    ];

    /**
     * Get the customer that owns the ticket.
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * Get the status associated with the ticket.
     */
    public function status()
    {
        return $this->belongsTo(TicketStatus::class, 'status_id');
    }

    /**
     * Determine if the ticket is marked as closed.
     */
    public function markedAsClosed()
    {
        return $this->status->marks_as_closed;
    }

    /**
     * Get the status history of the status changes for the ticket.
     */
    public function statusHistory()
    {
        return $this->hasMany(TicketStatusHistory::class);
    }

    /**
     * Get the priority associated with the ticket.
     */
    public function priority()
    {
        return $this->belongsTo(TicketPriority::class, 'priority_id');
    }

    /**
     * Get the priority history for the ticket.
     */
    public function priorityHistory()
    {
        return $this->hasMany(TicketPriorityHistory::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'ticket_user');
    }

    public function userHistory()
    {
        return $this->hasMany(TicketUserHistory::class);
    }

    /**
     * Get the notes associated with the ticket.
     */
    public function notes()
    {
        return $this->hasMany(TicketNote::class);
    }

    /**
     * Get a chronological timeline of all significant events related to the ticket,
     * including status changes, assignments, and notes.
     */
    public function timeline()
    {
        // Create a collection to hold all the timeline events
        $events = collect();

        // Collect the notes related to this ticket
        $this->notes()->with('user')->get()->each(function ($note) use ($events) {
            $events->push([
                'type' => TimelineEventType::Note,
                'timestamp' => $note->created_at,
                'data' => $note,
            ]);
        });

        // Collect the priority changes related to this ticket
        $this->priorityHistory()->with(['user', 'priority'])->get()->each(function (TicketPriorityHistory $priorityChange) use ($events): void {
            $events->push([
                'type' => TimelineEventType::PriorityChange,
                'timestamp' => $priorityChange->created_at,
                'data' => $priorityChange,
            ]);
        });

        // Collect the status changes related to this ticket
        $this->statusHistory()->with(['user', 'status'])->get()->each(function ($statusChange) use ($events) {
            $events->push([
                'type' => TimelineEventType::StatusChange,
                'timestamp' => $statusChange->created_at,
                'data' => $statusChange,
            ]);
        });

        // Collect the assigments changes related to this ticket
        $this->userHistory()->with('user', 'performer')->get()->each(function ($history) use ($events) {
            $events->push([
                'type' => $history->assigned ? TimelineEventType::Assigned : TimelineEventType::Unassigned,
                'timestamp' => $history->created_at,
                'data' => $history,
            ]);
        });

        return $events->sortBy('timestamp')->values();
    }
}
