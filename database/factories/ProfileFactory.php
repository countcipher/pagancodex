<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Profile>
 */
class ProfileFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'tradition' => fake()->randomElement(['Wicca', 'Druidry', 'Asatru', 'Eclectic', 'Hellenic Polytheism', null]),
            'clergy' => fake()->boolean(20),
            'bio' => fake()->paragraph(3),
            'city' => fake()->city(),
            'state_province' => fake()->stateAbbr(),
            'country' => 'US',
            'website' => fake()->optional(0.3)->url(),
            'facebook_url' => fake()->optional(0.3)->url(),
            'instagram_url' => fake()->optional(0.4)->url(),
            'x_url' => fake()->optional(0.2)->url(),
            'public_email' => fake()->optional(0.5)->safeEmail(),
            'phone_number' => fake()->optional(0.3)->phoneNumber(),
            'is_public' => fake()->boolean(80),
        ];
    }
}
