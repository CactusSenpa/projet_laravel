<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('quote_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('pack_id')->nullable()->constrained()->nullOnDelete();
            $table->string('customer_name');
            $table->string('customer_phone');
            $table->string('customer_email')->nullable();
            $table->string('cin')->nullable();
            $table->string('project_type')->nullable();
            $table->date('start_date');
            $table->date('end_date');
            $table->string('location');
            $table->string('address')->nullable();
            $table->boolean('delivery_required')->default(false);
            $table->decimal('delivery_fee', 10, 2)->nullable();
            $table->string('status')->default('pending');
            $table->decimal('estimated_price', 10, 2)->default(0);
            $table->decimal('deposit_amount', 10, 2)->default(0);
            $table->text('customer_message')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};
