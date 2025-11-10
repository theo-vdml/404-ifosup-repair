<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TicketUserHistory extends Model
{
    protected $table = 'ticket_user_history';

    protected $fillable = ['ticket_id', 'user_id', 'performer_id', 'assigned'];

    protected $casts = [
        'assigned' => 'boolean',
    ];

    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function performer()
    {
        return $this->belongsTo(User::class, 'performer_id');
    }
}
