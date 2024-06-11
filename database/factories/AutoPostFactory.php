<?php

namespace Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\AutoPost>
 */
class AutoPostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $start_at = fake()->unique()->dateTimeBetween(Carbon::now()->addDay(), Carbon::now()->addMonth());
        $end_at = Carbon::parse($start_at);
        $days = rand(0, 5);
        if($days > 0){
            $end_at->addDays($days);
        }
        return [
            'start_at' => $start_at,
            'end_at' => $end_at,
            'time_at' => fake()->unique()->time(),
        ];
    }
}
