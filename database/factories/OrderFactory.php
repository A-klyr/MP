<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'transaction_time' => $this->faker->dateTimeThisMonth(),
            'total_price' => 0, // Will be calculated based on items or updated later
            'total_item' => 0, // Will be calculated
            'kasir_id' => \App\Models\User::factory(),
            'payment_method' => $this->faker->randomElement(['cash', 'qris', 'transfer']),
        ];
    }
}
