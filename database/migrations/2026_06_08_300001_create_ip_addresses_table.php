<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ip_addresses', function (Blueprint $table) {
            $table->id();
            $table->string('ip_address', 45)->unique();
            $table->string('subnet_mask', 45)->nullable();
            $table->string('gateway', 45)->nullable();
            $table->string('dns_primary', 45)->nullable();
            $table->string('dns_secondary', 45)->nullable();
            $table->string('network_type')->default('LAN'); // LAN, WAN, WiFi, VPN
            $table->string('vlan')->nullable();
            $table->text('description')->nullable();
            $table->enum('status', ['available', 'allocated', 'reserved', 'decommissioned'])->default('available');
            $table->timestamps();
        });

        Schema::create('ip_allocations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ip_address_id')->constrained('ip_addresses')->onDelete('restrict');
            $table->foreignId('user_id')->constrained('users')->onDelete('restrict');
            $table->string('ethernet_mac', 17)->nullable();
            $table->string('wifi_mac', 17)->nullable();
            $table->string('dns_override', 45)->nullable();
            $table->string('device_name')->nullable();
            $table->string('device_type')->nullable(); // Desktop, Laptop, Server, Printer, etc.
            $table->date('date_allocated');
            $table->date('date_released')->nullable();
            $table->enum('status', ['active', 'released', 'suspended'])->default('active');
            $table->text('notes')->nullable();
            $table->foreignId('allocated_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ip_allocations');
        Schema::dropIfExists('ip_addresses');
    }
};
