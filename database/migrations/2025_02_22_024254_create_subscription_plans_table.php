<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('subscription_plans', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Plan name (Free, Standard, Pro)
            $table->decimal('price', 8, 2)->default(0); // Price of the plan
            $table->integer('event_limit')->nullable(); // Max events allowed
            $table->integer('attendee_limit')->nullable(); // Max attendees per event
            $table->boolean('seat_maps')->default(false); // Advanced feature
            $table->boolean('discount_codes')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscription_plans');
    }
};
