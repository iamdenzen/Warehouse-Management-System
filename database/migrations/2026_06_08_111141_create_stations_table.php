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
        Schema::create('stations', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('location')
                ->nullable();
            $table->string('esp32_led_host');
            $table->string('esp32_scale_host');
            $table->string('esp32_oled_host');
            $table->foreignId('printer_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();
            $table->integer('weight_tolerance_grams')
                ->default(50);
            $table->boolean('active')
                ->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stations');
    }
};
