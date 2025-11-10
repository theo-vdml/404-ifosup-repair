<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class TicketUser extends Pivot
{
    public $table = 'ticket_user';

    protected $fillable = ['ticket_id', 'user_id'];

    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
