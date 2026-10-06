<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('appliances', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedInteger('default_power_w');
            $table->decimal('default_duration_hours', 8, 2)->default(4);
            $table->boolean('has_startup_surge')->default(false);
            $table->decimal('startup_factor', 8, 2)->default(1);
            $table->string('category')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('appliances');
    }
};
