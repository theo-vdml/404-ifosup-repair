<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Ticket>
 */
class TicketFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'customer_id' => \App\Models\Customer::factory(),
            'title' => $this->faker->sentence(),
            'description' => $this->faker->paragraph(),
            'status_id' => \App\Models\TicketStatus::inRandomOrder()->first()->id,
            'priority_id' => \App\Models\TicketPriority::inRandomOrder()->first()->id,
        ];
    }
}
