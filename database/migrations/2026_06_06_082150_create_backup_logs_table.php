<?php
// database/migrations/2024_01_01_000014_create_backup_logs_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('backup_logs', function (Blueprint $table) {
            $table->id();
            $table->string('file_name', 255);
            $table->string('file_path', 500);
            $table->unsignedBigInteger('file_size')->nullable()
                  ->comment('In bytes');
            $table->enum('status', ['success', 'failed'])->default('success');
            $table->string('disk', 50)->default('local')
                  ->comment('Storage disk: local, s3, etc.');
            $table->text('notes')->nullable();
            $table->foreignId('created_by')->nullable()
                  ->references('id')->on('users')->nullOnDelete();
            $table->timestamps();

            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('backup_logs');
    }
};
