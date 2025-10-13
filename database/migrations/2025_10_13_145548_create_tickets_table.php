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
        Schema::create('tickets', function (Blueprint $table) {
            $table->id(); // Primary key (the ticket ID)
            $table->foreignId('customer_id') // Foreign key to the customers table
                ->constrained('customers')
                ->nullOnDelete()
                ->cascadeOnUpdate();
            $table->string('title'); // Title of the ticket
            $table->text('description'); // Detailed description of the issue
            $table->dateTime('closed_at') // Timestamp when the ticket was closed
                ->nullable();
            $table->timestamps(); // created_at and updated_at timestamps
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
