<?php

namespace App\Observers;

use App\Models\TicketUser;
use Illuminate\Support\Facades\Auth;

class TicketUserObserver
{
    public function created(TicketUser $ticketUser): void
    {
        $ticketUser->ticket->userHistory()->create([
            'user_id' => $ticketUser->user_id,
            'performer_id' => Auth::id(),
            'assigned' => true,
        ]);
    }

    public function deleted(TicketUser $ticketUser): void
    {
        $ticketUser->ticket->userHistory()->create([
            'user_id' => $ticketUser->user_id,
            'performer_id' => Auth::id(),
            'assigned' => false,
        ]);
    }
}
