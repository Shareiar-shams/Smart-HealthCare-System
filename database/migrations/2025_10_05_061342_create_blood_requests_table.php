<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // database/migrations/xxxx_create_blood_requests_table.php
public function up()
{
    Schema::create('blood_requests', function (Blueprint $table) {
        $table->id();
        $table->string('patient_name');
        $table->string('contact_person');
        $table->string('phone');
        $table->string('hospital');
        $table->enum('blood_group', ['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-']);
        $table->integer('units_required');
        $table->enum('urgency', ['low', 'medium', 'high', 'critical']);
        $table->string('division');
        $table->string('district');
        $table->date('required_date');
        $table->decimal('gratitude_fee', 10, 2);
        $table->text('additional_info')->nullable();
        $table->enum('status', ['pending', 'matched', 'fulfilled', 'cancelled'])->default('pending');
        $table->timestamps();
    });
}

 
};
