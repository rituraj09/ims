<?php
// database/migrations/2024_01_01_000004_create_departments_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('departments', function (Blueprint $table) {
            $table->id();
            $table->string('code', 20)->unique()->nullable()
                  ->comment('Short code for department e.g., IT, HR, FIN');
            $table->string('name', 150);
            $table->foreignId('parent_id')->nullable()
                  ->references('id')->on('departments')
                  ->nullOnDelete()
                  ->comment('For sub-departments / branches');
            $table->foreignId('head_user_id')->nullable()
                  ->references('id')->on('users')
                  ->nullOnDelete()
                  ->comment('Department Head / HOD');

            // Location Details
            $table->string('building', 100)->nullable();
            $table->string('block', 50)->nullable();
            $table->string('floor', 20)->nullable();
            $table->string('room_no', 30)->nullable();
            $table->text('address')->nullable();
            $table->string('city', 100)->nullable();
            $table->string('state', 100)->nullable();
            $table->string('pincode', 10)->nullable();

            // Contact
            $table->string('phone', 20)->nullable();
            $table->string('email', 150)->nullable();

            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->text('notes')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->index('status');
            $table->index('parent_id');
        });

        // Now add the foreign key for users.department_id
        Schema::table('users', function (Blueprint $table) {
            $table->foreign('department_id')
                  ->references('id')
                  ->on('departments')
                  ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['department_id']);
        });
        Schema::dropIfExists('departments');
    }
};
