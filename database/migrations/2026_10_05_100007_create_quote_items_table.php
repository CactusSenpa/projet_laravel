<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('quote_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('quote_id')->constrained()->cascadeOnDelete();
            $table->foreignId('appliance_id')->nullable()->constrained()->nullOnDelete();
            $table->string('name');
            $table->unsignedInteger('power_w');
            $table->unsignedInteger('quantity');
            $table->decimal('duration_hours', 8, 2);
            $table->string('usage_period')->default('jour');
            $table->boolean('has_startup_surge')->default(false);
            $table->unsignedInteger('startup_power_w')->nullable();
            $table->decimal('energy_wh', 12, 2);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('quote_items');
    }
};
