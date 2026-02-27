<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Shop>
 */
class ShopFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $nouns = ['Wand', 'Cauldron', 'Moon', 'Raven', 'Crystal', 'Tarot', 'Herb'];
        $types = ['Shoppe', 'Varieties', 'Apothecary', 'Emporium', 'Books'];

        return [
            'name' => 'The ' . fake()->randomElement($nouns) . ' ' . fake()->randomElement($types),
            'description' => fake()->paragraphs(2, true),
            'country' => 'US',
            'state_province' => fake()->stateAbbr(),
            'city' => fake()->city(),
            'is_public' => fake()->boolean(85),
            'contact_email' => fake()->safeEmail(),
            'phone_number' => fake()->optional(0.6)->phoneNumber(),
            'website' => fake()->optional(0.4)->url(),
            'facebook_url' => fake()->optional(0.5)->url(),
            'instagram_url' => fake()->optional(0.7)->url(),
            'hours_monday' => fake()->boolean(80) ? '10:00 AM - 6:00 PM' : 'Closed',
            'hours_tuesday' => fake()->boolean(80) ? '10:00 AM - 6:00 PM' : 'Closed',
            'hours_wednesday' => fake()->boolean(80) ? '10:00 AM - 6:00 PM' : 'Closed',
            'hours_thursday' => '10:00 AM - 8:00 PM',
            'hours_friday' => '10:00 AM - 8:00 PM',
            'hours_saturday' => '11:00 AM - 5:00 PM',
            'hours_sunday' => fake()->boolean(50) ? '12:00 PM - 5:00 PM' : 'Closed',
        ];
    }
}
