<?php
// database/migrations/2024_01_01_000005_create_vendors_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vendors', function (Blueprint $table) {
            $table->id();
            $table->string('code', 20)->unique()->nullable()
                  ->comment('Vendor short code');
            $table->string('name', 150);
            $table->string('contact_person', 100)->nullable();
            $table->string('mobile', 15)->nullable();
            $table->string('phone', 20)->nullable();
            $table->string('email', 150)->nullable();
            $table->string('website', 255)->nullable();

            // Address
            $table->text('address')->nullable();
            $table->string('city', 100)->nullable();
            $table->string('state', 100)->nullable();
            $table->string('pincode', 10)->nullable();
            $table->string('country', 100)->default('India');

            // GST & Financial
            $table->string('gstin', 20)->nullable()
                  ->comment('GST Identification Number');
            $table->string('pan', 15)->nullable();
            $table->string('bank_name', 100)->nullable();
            $table->string('bank_account_no', 30)->nullable();
            $table->string('bank_ifsc', 15)->nullable();

            // AMC
            $table->boolean('provides_amc')->default(false)
                  ->comment('Whether vendor provides AMC service');
            $table->text('amc_terms')->nullable();

            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->text('notes')->nullable();

            $table->foreignId('created_by')->nullable()
                  ->references('id')->on('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()
                  ->references('id')->on('users')->nullOnDelete();

            $table->timestamps();
            $table->softDeletes();

            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vendors');
    }
};
