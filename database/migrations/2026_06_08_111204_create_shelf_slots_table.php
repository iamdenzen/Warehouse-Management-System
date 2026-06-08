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
        Schema::create('shelf_slots', function (Blueprint $table) {
            $table->id();
            $table->foreignId('shelf_id')
                ->constrained()
                ->cascadeOnDelete();
            $table->string('label');
            $table->unsignedInteger('led_from');
            $table->unsignedInteger('led_to');
            $table->string('oled_channel_front');
            $table->string('oled_channel_back');
            $table->foreignId('current_product_id')
                ->nullable()
                ->constrained('products')
                ->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shelf_slots');
    }
};
