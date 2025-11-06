<?php

namespace App\Http\Controllers;

use App\Models\TicketNoteAttachment;
use Illuminate\Support\Facades\Storage;

class AttachmentController extends Controller
{
    public function download(TicketNoteAttachment $attachment)
    {
        if (!Storage::exists($attachment->file_path)) {
            abort(404, 'File not found.');
        }

        // Return the file download
        return Storage::download($attachment->file_path, $attachment->file_name);
    }
}
