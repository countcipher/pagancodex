<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Group>
 */
class GroupFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $groupTypes = ['Coven', 'Grove', 'Kindred', 'Circle', 'Alliance', 'Order'];
        $element = fake()->randomElement(['Oak', 'Moon', 'Sun', 'Raven', 'Wolf', 'Star', 'Earth', 'Fire']);

        return [
            'name' => fake()->randomElement($groupTypes) . ' of the ' . $element,
            'tradition' => fake()->randomElement(['Wicca', 'Druidry', 'Asatru', 'Eclectic Pagans', null]),
            'description' => fake()->paragraphs(2, true),
            'country' => 'US',
            'state_province' => fake()->stateAbbr(),
            'city' => fake()->city(),
            'has_clergy' => fake()->boolean(30),
            'is_public' => fake()->boolean(80),
            'contact_email' => fake()->safeEmail(),
            'phone_number' => fake()->optional(0.4)->phoneNumber(),
            'website' => fake()->optional(0.5)->url(),
            'facebook_url' => fake()->optional(0.6)->url(),
            'instagram_url' => fake()->optional(0.5)->url(),
        ];
    }
}
