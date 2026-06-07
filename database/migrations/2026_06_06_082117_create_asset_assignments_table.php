<?php
// database/migrations/2024_01_01_000008_create_asset_assignments_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('asset_assignments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('asset_id')
                  ->constrained('assets')->cascadeOnDelete();

            // Type of transaction
            $table->enum('transaction_type', [
                'handover',     // Asset assigned to dept/employee
                'takeover',     // Asset taken back from dept/employee
                'transfer',     // Asset transferred between dept/employees
                'maintenance',  // Sent for maintenance
                'returned',     // Returned from maintenance
                'disposed',     // Asset disposed
                'lost',         // Reported lost
                'found'         // Found after being lost
            ]);

            // From (previous holder)
            $table->enum('from_type', ['department', 'employee', 'store', 'vendor'])->nullable();
            $table->foreignId('from_department_id')->nullable()
                  ->references('id')->on('departments')->nullOnDelete();
            $table->foreignId('from_employee_id')->nullable()
                  ->references('id')->on('users')->nullOnDelete();
            $table->string('from_location_building', 100)->nullable();
            $table->string('from_location_floor', 20)->nullable();
            $table->string('from_location_room_no', 30)->nullable();

            // To (new holder)
            $table->enum('to_type', ['department', 'employee', 'store', 'vendor'])->nullable();
            $table->foreignId('to_department_id')->nullable()
                  ->references('id')->on('departments')->nullOnDelete();
            $table->foreignId('to_employee_id')->nullable()
                  ->references('id')->on('users')->nullOnDelete();
            $table->string('to_location_building', 100)->nullable();
            $table->string('to_location_floor', 20)->nullable();
            $table->string('to_location_room_no', 30)->nullable();

            // Condition at time of transaction
            $table->enum('condition_at_handover', ['new', 'good', 'fair', 'poor', 'condemned'])
                  ->nullable();
            $table->enum('condition_at_return', ['new', 'good', 'fair', 'poor', 'condemned'])
                  ->nullable();

            // Dates
            $table->date('transaction_date');
            $table->date('expected_return_date')->nullable()
                  ->comment('For maintenance / temporary transfers');
            $table->date('actual_return_date')->nullable();

            // Physical Form
            $table->string('form_no', 50)->nullable()
                  ->comment('Auto-generated handover/takeover form number');
            $table->string('handover_form_path')->nullable()
                  ->comment('Uploaded signed physical form');

            // Signatures & Acknowledgment
            $table->boolean('handover_acknowledged')->default(false);
            $table->timestamp('handover_acknowledged_at')->nullable();
            $table->boolean('takeover_acknowledged')->default(false);
            $table->timestamp('takeover_acknowledged_at')->nullable();

            // Authorized by
            $table->foreignId('authorized_by')->nullable()
                  ->references('id')->on('users')->nullOnDelete();

            $table->text('remarks')->nullable();

            $table->foreignId('created_by')->nullable()
                  ->references('id')->on('users')->nullOnDelete();

            $table->timestamps();

            $table->index(['asset_id', 'transaction_type']);
            $table->index('transaction_date');
            $table->index('form_no');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('asset_assignments');
    }
};
