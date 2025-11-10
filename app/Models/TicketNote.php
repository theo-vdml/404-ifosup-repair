<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;

class TicketNote extends Model
{
    protected $fillable = ['ticket_id', 'user_id', 'message'];

    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function attachments()
    {
        return $this->hasMany(TicketNoteAttachment::class);
    }

    public function attachFiles(array $files)
    {
        foreach ($files as $file) {
            if ($file instanceof UploadedFile && $file->isValid()) {
                $path = $file->store('attachments');
                $this->attachments()->create([
                    'file_path' => $path,
                    'file_name' => $file->getClientOriginalName(),
                ]);
            }
        }
    }
}
