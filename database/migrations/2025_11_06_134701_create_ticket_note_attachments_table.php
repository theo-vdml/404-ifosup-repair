<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('ticket_note_attachments', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('ticket_note_id')->constrained('ticket_notes');
            $table->string('file_path');
            $table->string('file_name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ticket_note_attachments');
    }
};
