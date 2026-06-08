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
        Schema::create('delivery_notes', function (Blueprint $table) {
            $table->id();
            $table->string('document_number')
                ->index();
            $table->string('sales_order_id')
                ->nullable();
            $table->string('xentral_delivery_note_id')
                ->nullable();
            $table->string('status')
                ->default('in_progress');
            $table->foreignId('station_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();
            $table->foreignId('user_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();
            $table->string('tracking_number')
                ->nullable();
            $table->longText('label_pdf_base64')
                ->nullable();
            $table->string('printnode_job_id')
                ->nullable();
            $table->decimal('total_weight_grams', 10, 2)
                ->nullable();
            $table->timestamp('started_at')
                ->nullable();
            $table->timestamp('weighed_at')
                ->nullable();
            $table->timestamp('labeled_at')
                ->nullable();
            $table->timestamp('printed_at')
                ->nullable();
            $table->timestamp('completed_at')
                ->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('delivery_notes');
    }
};
