<?php
// database/migrations/2024_01_01_000012_create_activity_logs_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()
                  ->references('id')->on('users')->nullOnDelete();
            $table->string('user_name', 150)->nullable()
                  ->comment('Snapshot of user name');

            $table->string('action', 50)
                  ->comment('created, updated, deleted, assigned, transferred, etc.');
            $table->string('module', 50)
                  ->comment('assets, departments, employees, vendors, settings');
            $table->string('subject_type', 100)->nullable()
                  ->comment('Model class name');
            $table->unsignedBigInteger('subject_id')->nullable()
                  ->comment('Model ID');
            $table->string('subject_label', 200)->nullable()
                  ->comment('Human readable subject e.g., Asset Tag or name');

            $table->json('old_values')->nullable()
                  ->comment('Previous data snapshot');
            $table->json('new_values')->nullable()
                  ->comment('New data snapshot');

            $table->string('ip_address', 45)->nullable();
            $table->string('user_agent', 500)->nullable();
            $table->text('description')->nullable();

            $table->timestamp('created_at')->useCurrent();

            $table->index(['module', 'subject_type', 'subject_id']);
            $table->index(['user_id', 'created_at']);
            $table->index('action');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
    }
};
