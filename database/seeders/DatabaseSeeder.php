<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // First, check if there's already a Test User to avoid duplicate email errors on migration refresh
        if (!User::where('email', 'test@example.com')->exists()) {
            User::factory()->create([
                'name' => 'Test User',
                'email' => 'test@example.com',
            ])->each(function (User $user) {
                $user->profile()->update(\App\Models\Profile::factory()->make()->toArray());
            });
        }

        // Generate 50 Users. 
        // Because of the User model's boot method, a blank profile is created automatically.
        User::factory(50)->create()->each(function (User $user) {

            // 1. Update the blank profile with realistic fake data
            $user->profile()->update(
                \App\Models\Profile::factory()->make()->toArray()
            );

            // 2. Create 1 Group, 1 Event, and 1 Shop assigned to this User
            \App\Models\Group::factory()->create(['user_id' => $user->id]);
            \App\Models\Event::factory()->create(['user_id' => $user->id]);
            \App\Models\Shop::factory()->create(['user_id' => $user->id]);

        });
    }
}
