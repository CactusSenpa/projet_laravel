<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('reference')->unique();
            $table->text('description')->nullable();
            $table->unsignedInteger('power_w')->nullable();
            $table->unsignedInteger('voltage_v')->nullable();
            $table->unsignedInteger('capacity_wh')->nullable();
            $table->decimal('capacity_ah', 10, 2)->nullable();
            $table->unsignedInteger('surge_power_w')->nullable();
            $table->decimal('daily_price', 10, 2);
            $table->decimal('deposit', 10, 2)->default(0);
            $table->unsignedInteger('quantity')->default(1);
            $table->string('image')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
