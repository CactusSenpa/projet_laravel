<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('quotes', function (Blueprint $table) {
            $table->id();
            $table->string('project_type');
            $table->decimal('total_energy_wh', 12, 2);
            $table->decimal('energy_with_margin_wh', 12, 2);
            $table->decimal('max_simultaneous_power_w', 12, 2);
            $table->decimal('peak_power_w', 12, 2);
            $table->decimal('recommended_battery_wh', 12, 2);
            $table->decimal('recommended_battery_ah', 12, 2);
            $table->unsignedInteger('battery_voltage')->default(48);
            $table->decimal('recommended_inverter_w', 12, 2);
            $table->decimal('recommended_solar_w', 12, 2);
            $table->foreignId('recommended_pack_id')->nullable()->constrained('packs')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('quotes');
    }
};
