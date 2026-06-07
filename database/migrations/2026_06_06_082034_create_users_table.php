<?php
// database/migrations/2024_01_01_000003_create_users_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();

            // Personal Information
            $table->string('employee_id', 50)->unique()->nullable()
                  ->comment('Government Employee ID / Staff ID');
            $table->string('name', 150);
            $table->string('email', 150)->unique()->nullable();
            $table->string('mobile', 15)->nullable();
            $table->enum('gender', ['male', 'female', 'other'])->nullable();
            $table->string('profile_photo')->nullable();

            // Designation & Department
            $table->foreignId('designation_id')->nullable()
                  ->constrained('designations')->nullOnDelete();
            $table->foreignId('department_id')->nullable()
                  ->comment('Will be set after departments table is created')
                  ->index();

            // Auth Fields
            $table->string('password')->nullable()
                  ->comment('Null if employee is not a system user');
            $table->foreignId('role_id')->nullable()
                  ->constrained('roles')->nullOnDelete();
            $table->boolean('is_system_user')->default(false)
                  ->comment('True if the employee has login access');
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();

            // Status
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->date('joining_date')->nullable();
            $table->date('leaving_date')->nullable();
            $table->text('notes')->nullable();

            $table->timestamps();
            $table->softDeletes();

            // Indexes
            $table->index(['status', 'is_system_user']);
            $table->index('role_id');
        });

        // Additional permissions per user (override role permissions)
        Schema::create('user_permissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('permission_id')->constrained('permissions')->cascadeOnDelete();
            $table->enum('type', ['grant', 'deny'])->default('grant')
                  ->comment('grant = extra permission, deny = revoke from role');
            $table->timestamps();

            $table->unique(['user_id', 'permission_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_permissions');
        Schema::dropIfExists('users');
    }
};
