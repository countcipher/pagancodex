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
        Schema::create('groups', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();

            // Core Info
            $table->string('name');
            $table->string('tradition')->nullable();
            $table->text('description');

            // Location
            $table->string('country', 2)->comment('US or CA');
            $table->string('state_province', 2)->nullable();
            $table->string('city');

            // Details & Settings
            $table->boolean('has_clergy')->default(false);
            $table->boolean('is_public')->default(true);

            // Contact & Social
            $table->string('contact_email')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('website')->nullable();
            $table->string('facebook_url')->nullable();
            $table->string('instagram_url')->nullable();
            $table->string('x_url')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('groups');
    }
};
