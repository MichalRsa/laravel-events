<?php

namespace Database\Factories;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Event>
 */
class EventFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'title' => $this->faker->title(),
            'description' => $this->faker->text(500),
            /*2025-12-12T12:12*/
            'start_time' => $this->faker->dateTimeThisYear(),
            /*2025-12-12T21:00*/
            'end_time' => $this->faker->dateTimeThisYear(),
            'location' => $this->faker->city(),
            'team_id' => 11,
            'created_at' => Carbon::now()->format('Y-m-d\TH:i'),
        ];
    }
}
