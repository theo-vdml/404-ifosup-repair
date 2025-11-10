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
        Schema::create('ticket_status_history', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            // The ID of the ticket whose status changed
            $table->foreignId('ticket_id')->constrained('tickets');
            // The ID of the user who made the status change
            $table->foreignId('user_id')->nullable()->constrained('users');
            // The ID of the new status
            $table->foreignId('status_id')->constrained('ticket_statuses');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ticket_status_history');
    }
};
