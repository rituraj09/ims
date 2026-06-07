<?php
// database/migrations/2024_01_01_000007_create_assets_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('assets', function (Blueprint $table) {
            $table->id();

            // ── Identification ──────────────────────────────────────────
            $table->string('asset_tag', 50)->unique()
                  ->comment('Auto-generated tag based on settings format');
            $table->string('name', 200);
            $table->string('asset_type', 50)->nullable()
                  ->comment('Movable / Immovable / IT / Non-IT');

            // Category & Sub-Category
            $table->foreignId('category_id')
                  ->constrained('asset_categories')
                  ->restrictOnDelete();
            $table->string('sub_category_id')->nullable()
                  ->comment('UUID stored in asset_categories.sub_categories JSON');
            $table->string('sub_category_name', 100)->nullable()
                  ->comment('Snapshot of sub-category name at time of entry');

            // Brand & Model
            $table->string('make_brand', 100)->nullable();
            $table->string('model', 100)->nullable();
            $table->string('serial_no', 100)->nullable()->unique();
            $table->text('description')->nullable();

            // ── Purchase & Financial Details ────────────────────────────
            $table->date('purchase_date')->nullable();
            $table->decimal('purchase_price', 12, 2)->nullable();
            $table->date('warranty_expiry_date')->nullable();

            $table->boolean('under_amc')->default(false);
            $table->date('amc_start_date')->nullable();
            $table->date('amc_end_date')->nullable();
            $table->string('amc_reference_no', 100)->nullable();

            $table->foreignId('vendor_id')->nullable()
                  ->constrained('vendors')->nullOnDelete();
            $table->string('invoice_no', 100)->nullable();
            $table->string('invoice_file')->nullable()
                  ->comment('Uploaded invoice file path');

            $table->decimal('depreciation_rate', 5, 2)->nullable()
                  ->comment('% per annum - auto-filled from category, editable');
            $table->decimal('current_value', 12, 2)->nullable()
                  ->comment('Auto-calculated based on depreciation');

            // ── Status & Condition ──────────────────────────────────────
            $table->enum('status', [
                'available',
                'in_use',
                'under_maintenance',
                'disposed',
                'lost',
                'transferred'
            ])->default('available');

            $table->enum('condition', [
                'new',
                'good',
                'fair',
                'poor',
                'condemned'
            ])->default('new');

            // ── Assignment ──────────────────────────────────────────────
            $table->enum('assigned_to_type', ['department', 'employee'])->nullable()
                  ->comment('Determines if asset is with a dept or employee');

            $table->foreignId('assigned_department_id')->nullable()
                  ->references('id')->on('departments')->nullOnDelete();

            $table->foreignId('assigned_employee_id')->nullable()
                  ->references('id')->on('users')->nullOnDelete();

            // Physical Location (common for both dept & employee assignment)
            $table->string('location_building', 100)->nullable();
            $table->string('location_block', 50)->nullable();
            $table->string('location_floor', 20)->nullable();
            $table->string('location_room_no', 30)->nullable();

            $table->date('assigned_on')->nullable();
            $table->text('assignment_notes')->nullable();

            // ── Disposal Details ────────────────────────────────────────
            $table->date('disposed_on')->nullable();
            $table->string('disposal_method', 100)->nullable()
                  ->comment('Auction, Scrap, Donation, Written-off');
            $table->decimal('disposal_value', 12, 2)->nullable();
            $table->text('disposal_notes')->nullable();

            // ── QR / Barcode ────────────────────────────────────────────
            $table->string('qr_code_path')->nullable()
                  ->comment('Path to generated QR code image');

            // ── Audit ───────────────────────────────────────────────────
            $table->foreignId('created_by')->nullable()
                  ->references('id')->on('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()
                  ->references('id')->on('users')->nullOnDelete();

            $table->timestamps();
            $table->softDeletes();

            // Indexes for common queries
            $table->index('asset_tag');
            $table->index('status');
            $table->index('condition');
            $table->index(['category_id', 'status']);
            $table->index('assigned_to_type');
            $table->index(['assigned_department_id', 'status']);
            $table->index(['assigned_employee_id', 'status']);
            $table->index('under_amc');
            $table->index('warranty_expiry_date');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('assets');
    }
};
