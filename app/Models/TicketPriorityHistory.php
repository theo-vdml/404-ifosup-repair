<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TicketPriorityHistory extends Model
{
    protected $table = 'ticket_priority_history';

    protected $fillable = ['ticket_id', 'user_id', 'priority_id'];

    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function priority()
    {
        return $this->belongsTo(TicketPriority::class, 'priority_id');
    }
}
