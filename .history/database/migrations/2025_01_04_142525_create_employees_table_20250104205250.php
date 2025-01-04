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
        Schema::create('employees', function (Blueprint $table) {
            $table->id(); // ID-ul automat
            $table->string('name'); // Nume
            $table->string('phone'); // Număr de telefon
            $table->string('email')->unique(); // Email unic
            $table->string('function')->unique(); // Email unic
            $table->unsignedBigInteger('role_id'); // Foreign key pentru rol
            $table->unsignedBigInteger('department_id'); // Foreign key pentru departament
            $table->unsignedBigInteger('hotel_id');
            $table->foreign('role_id')->references('id')->on('roles'); // Relația cu tabelele asociate
            $table->foreign('department_id')->references('id')->on('departments'); // Relația cu departamentele
            $table->foreign('hotel_id')->references('id')->on('hotels'); // Relația cu hotelurile
            $table->timestamps(); // Timestamps (created_at, updated_at)
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
