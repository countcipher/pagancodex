<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('shops', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();

            // Basic Info
            $table->string('name');
            $table->text('description');

            // Location
            $table->string('country');
            $table->string('state_province')->nullable();
            $table->string('city');

            // Preferences
            $table->boolean('is_public')->default(false);

            // Contact & Socials
            $table->string('contact_email')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('website')->nullable();
            $table->string('facebook_url')->nullable();
            $table->string('instagram_url')->nullable();
            $table->string('x_url')->nullable();

            // Operating Hours
            $table->string('hours_monday')->nullable();
            $table->string('hours_tuesday')->nullable();
            $table->string('hours_wednesday')->nullable();
            $table->string('hours_thursday')->nullable();
            $table->string('hours_friday')->nullable();
            $table->string('hours_saturday')->nullable();
            $table->string('hours_sunday')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shops');
    }
};
