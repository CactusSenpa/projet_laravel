<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('availabilities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->nullable()->constrained()->cascadeOnDelete();
            $table->foreignId('pack_id')->nullable()->constrained()->cascadeOnDelete();
            $table->date('date');
            $table->unsignedInteger('quantity_total')->default(0);
            $table->unsignedInteger('quantity_reserved')->default(0);
            $table->unsignedInteger('quantity_available')->default(0);
            $table->unique(['pack_id', 'date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('availabilities');
    }
};
