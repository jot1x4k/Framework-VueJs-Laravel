<?php

namespace Database\Factories;

use App\Models\Appointment;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Appointment>
 */
class AppointmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::query()
                ->inRandomOrder()
                ->value('id') ?? User::factory()->create()->id,
            'reason' => fake()->text(100),
            'date' => fake()->dateTimeThisYear()
        ];
    }
}
