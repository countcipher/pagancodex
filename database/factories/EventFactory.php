<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;

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
        $startDate = fake()->dateTimeBetween('-1 month', '+6 months');
        $endDate = (clone $startDate)->modify('+' . fake()->numberBetween(0, 3) . ' days');

        $eventTypes = ['Festival', 'Ritual', 'Gathering', 'Workshop', 'Market', 'Retreat'];
        $theme = fake()->randomElement(['Beltane', 'Samhain', 'Mabon', 'Yule', 'Spring', 'Autumn', 'Moon']);

        return [
            'title' => $theme . ' ' . fake()->randomElement($eventTypes),
            'details' => fake()->paragraphs(3, true),
            'country' => 'US',
            'state_province' => fake()->stateAbbr(),
            'city' => fake()->city(),
            'start_date' => $startDate->format('Y-m-d'),
            'end_date' => $endDate->format('Y-m-d'),
            'is_public' => fake()->boolean(90),
        ];
    }
}
