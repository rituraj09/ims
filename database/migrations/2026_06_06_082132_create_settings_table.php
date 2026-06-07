<?php
// database/migrations/2024_01_01_000011_create_settings_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('group', 50)
                  ->comment('general, organisation, asset_tag, notification, backup, email');
            $table->string('key', 100);
            $table->longText('value')->nullable();
            $table->string('type', 30)->default('text')
                  ->comment('text, textarea, boolean, json, integer, file');
            $table->string('label', 200)->nullable()
                  ->comment('Human readable label for UI');
            $table->text('description')->nullable();
            $table->boolean('is_public')->default(false)
                  ->comment('If true, accessible without auth (e.g., org name)');
            $table->timestamps();

            $table->unique(['group', 'key']);
            $table->index('group');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
