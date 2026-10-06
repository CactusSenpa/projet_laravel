<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('packs', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->decimal('price_per_day', 10, 2);
            $table->decimal('deposit', 10, 2)->default(0);
            $table->unsignedInteger('energy_capacity_wh');
            $table->unsignedInteger('continuous_power_w');
            $table->unsignedInteger('surge_power_w')->nullable();
            $table->json('recommended_uses')->nullable();
            $table->string('image')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('packs');
    }
};
