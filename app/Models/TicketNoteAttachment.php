<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TicketNoteAttachment extends Model
{
    protected $fillable = [
        'ticket_note_id',
        'file_path',
        'file_name',
    ];

    public function ticketNote()
    {
        return $this->belongsTo(TicketNote::class);
    }
}
