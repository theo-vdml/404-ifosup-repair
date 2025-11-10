<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('ticket_statuses', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('code')->unique();
            $table->string('label')->nullable();
            $table->string('color')->nullable();
            $table->string('icon')->nullable();
            $table->boolean('is_builtin')->default(false); // Indicates if this is a built-in status (like OPEN and CLOSED)
            $table->boolean('marks_as_closed')->default(false); // Indicates if this status means the ticket is closed
        });

        // Insert built-in statuses
        DB::table('ticket_statuses')->insert([
            [
                'code' => 'open',
                'label' => 'Ouvert',
                'color' => 'emerald',
                'icon' => 'heroicon-o-minus-circle',
                'is_builtin' => true,
                'marks_as_closed' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => 'closed_uncompleted',
                'label' => 'Échoué',
                'color' => 'red',
                'icon' => 'heroicon-o-x-circle',
                'is_builtin' => true,
                'marks_as_closed' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => 'closed',
                'label' => 'Terminé',
                'color' => 'purple',
                'icon' => 'heroicon-o-check-circle',
                'is_builtin' => true,
                'marks_as_closed' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ticket_statuses');
    }
};
