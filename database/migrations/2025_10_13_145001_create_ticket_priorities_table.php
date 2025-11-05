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
        Schema::create('ticket_priorities', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('code')->unique(); // Internal reference (e.g. "low", "medium", "high")
            $table->string('label')->nullable(); // Custom display name (optional, fallback to i18n)
            $table->unsignedTinyInteger('level')->default(0); // Lower = higher priority (e.g. 1=high)
            $table->boolean('is_builtin')->default(false); // Protects default priorities from deletion
        });

        // Insert built-in priorities
        DB::table('ticket_priorities')->insert([
            [
                'code' => 'high',
                'label' => null,
                'level' => 1,
                'is_builtin' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => 'medium',
                'label' => null,
                'level' => 2,
                'is_builtin' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => 'low',
                'label' => null,
                'level' => 3,
                'is_builtin' => true,
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
        Schema::dropIfExists('ticket_priorities');
    }
};
