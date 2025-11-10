<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TicketStatusHistory extends Model
{
    protected $table = 'ticket_status_history';

    protected $fillable = ['ticket_id', 'user_id', 'status_id'];

    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function status()
    {
        return $this->belongsTo(TicketStatus::class);
    }
}
