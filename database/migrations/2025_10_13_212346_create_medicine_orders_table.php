<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('medicine_orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('prescription_id')->constrained('prescriptions')->onDelete('cascade');
            $table->foreignId('patient_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('pharmacy_id')->nullable()->constrained('pharmacies')->onDelete('set null');
            $table->enum('status', ['pending', 'processing', 'ready', 'out_for_delivery', 'delivered', 'cancelled'])->default('pending');
            $table->decimal('total_price', 10, 2)->default(0);
            $table->enum('payment_status', ['pending', 'paid', 'failed'])->default('pending');
            $table->enum('payment_method', ['cash', 'card', 'online'])->nullable();
            $table->text('delivery_address')->nullable();
            $table->text('special_instructions')->nullable();
            $table->timestamp('ordered_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medicine_orders');
    }
};
