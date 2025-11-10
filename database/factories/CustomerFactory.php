<?php

namespace Database\Factories;

use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Customer>
 */
class CustomerFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Customer::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $firstName = $this->faker->firstName();
        $lastName = $this->faker->lastName();

        // Nettoyer les accents et caractères spéciaux
        $normalize = function ($string): array|string|null {
            // Remplacer les caractères accentués par leur équivalent non accentué
            $string = iconv('UTF-8', 'ASCII//TRANSLIT', $string);
            // Supprimer les caractères non alphanumériques
            return preg_replace('/[^a-z0-9]/i', '', $string);
        };

        $cleanFirst = strtolower($normalize($firstName));
        $cleanLast = strtolower($normalize($lastName));

        $email = $cleanFirst . '.' . $cleanLast . '@' . $this->faker->freeEmailDomain();

        return [
            'first_name' => $firstName,
            'last_name' => $lastName,
            'email' => $email,
            'phone' => $this->faker->optional(0.5)->phoneNumber(),
            'address' => $this->faker->optional(0.4)->address(),
            'notes' => $this->faker->optional(0.3)->sentence(),
        ];
    }
}
