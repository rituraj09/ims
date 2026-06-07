<?php
// database/migrations/2024_01_01_000009_create_asset_maintenances_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('asset_maintenances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('asset_id')
                  ->constrained('assets')->cascadeOnDelete();

            $table->enum('maintenance_type', [
                'preventive',
                'corrective',
                'amc',
                'calibration',
                'inspection',
                'other'
            ]);

            $table->string('reference_no', 50)->nullable();
            $table->date('scheduled_date')->nullable();
            $table->date('start_date');
            $table->date('completion_date')->nullable();

            $table->foreignId('vendor_id')->nullable()
                  ->constrained('vendors')->nullOnDelete()
                  ->comment('Service vendor / AMC vendor');
            $table->string('technician_name', 100)->nullable();
            $table->string('technician_contact', 20)->nullable();

            $table->text('issue_description')->nullable();
            $table->text('work_done')->nullable();
            $table->text('parts_replaced')->nullable();

            $table->decimal('maintenance_cost', 10, 2)->nullable();
            $table->string('invoice_no', 100)->nullable();
            $table->string('invoice_file')->nullable();

            $table->enum('status', [
                'scheduled',
                'in_progress',
                'completed',
                'cancelled'
            ])->default('scheduled');

            $table->enum('condition_after', ['new', 'good', 'fair', 'poor', 'condemned'])
                  ->nullable();

            $table->text('remarks')->nullable();
            $table->string('document_path')->nullable()
                  ->comment('Any maintenance report / certificate');

            $table->foreignId('created_by')->nullable()
                  ->references('id')->on('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()
                  ->references('id')->on('users')->nullOnDelete();

            $table->timestamps();

            $table->index(['asset_id', 'status']);
            $table->index('scheduled_date');
            $table->index('completion_date');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('asset_maintenances');
    }
};
