<?php

namespace Database\Factories;

use App\Models\Status;
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
            'user_id' => 3,
            'total' => $this->faker->numberBetween(10000, 5000000),
            'address' => $this->faker->address,
            'status_id' => Status::inRandomOrder()->first(),
        ];
    }
}
