<?php
// database/migrations/2024_01_01_000006_create_asset_categories_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('asset_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->string('code', 20)->unique()
                  ->comment('Unique code used in Asset Tag generation');
            $table->text('description')->nullable();

            // Icon - predefined icon class (e.g., FontAwesome / Bootstrap Icons)
            $table->string('icon', 100)->nullable()
                  ->comment('CSS icon class e.g., fas fa-laptop, fas fa-chair');

            $table->decimal('depreciation_rate', 5, 2)->nullable()
                  ->comment('Annual depreciation rate in percentage');

            $table->enum('status', ['active', 'inactive'])->default('active');

            /*
             * Sub-categories stored as JSON array
             * Format: [{"id": "uuid", "name": "Laptop", "code": "LAP", "description": "...", "status": "active"}]
             */
            $table->json('sub_categories')->nullable()
                  ->comment('JSON array of sub-category objects');

            $table->foreignId('created_by')->nullable()
                  ->references('id')->on('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()
                  ->references('id')->on('users')->nullOnDelete();

            $table->timestamps();
            $table->softDeletes();

            $table->index('status');
            $table->index('code');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('asset_categories');
    }
};
