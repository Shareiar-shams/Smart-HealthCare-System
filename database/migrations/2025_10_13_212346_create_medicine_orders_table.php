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
            $table->foreignId('prescription_id')->constrained()->onDelete('cascade');
            $table->foreignId('patient_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('pharmacy_id')->nullable()->constrained('users')->onDelete('set null');
            $table->enum('status', ['Pending', 'Accepted', 'Processing', 'Ready for Delivery', 'Delivered', 'Cancelled'])->default('Pending');
            $table->decimal('total_price', 10, 2)->default(0);
            $table->string('payment_status')->default('Unpaid');
            $table->string('payment_method')->nullable(); 
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
