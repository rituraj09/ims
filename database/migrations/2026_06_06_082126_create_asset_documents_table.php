<?php
// database/migrations/2024_01_01_000010_create_asset_documents_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('asset_documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('asset_id')
                  ->constrained('assets')->cascadeOnDelete();

            $table->enum('document_type', [
                'invoice',
                'warranty_card',
                'manual',
                'amc_contract',
                'handover_form',
                'takeover_form',
                'inspection_report',
                'maintenance_report',
                'disposal_certificate',
                'other'
            ]);

            $table->string('title', 200);
            $table->text('description')->nullable();
            $table->string('file_path', 500);
            $table->string('file_name', 255);
            $table->string('file_type', 50)->nullable()
                  ->comment('MIME type');
            $table->unsignedBigInteger('file_size')->nullable()
                  ->comment('In bytes');

            // Link to relevant transaction
            $table->foreignId('assignment_id')->nullable()
                  ->references('id')->on('asset_assignments')->nullOnDelete();
            $table->foreignId('maintenance_id')->nullable()
                  ->references('id')->on('asset_maintenances')->nullOnDelete();

            $table->foreignId('uploaded_by')->nullable()
                  ->references('id')->on('users')->nullOnDelete();

            $table->timestamps();
            $table->softDeletes();

            $table->index(['asset_id', 'document_type']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('asset_documents');
    }
};
