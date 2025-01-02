<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('departments', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id(); // Cheia primară
            $table->string('name'); // Numele departamentului
            $table->string('description')->nullable(); // Descrierea departamentului (opțional)
            $table->string('color')->nullable(); // Adăugăm coloana "color"
            $table->timestamps(); // Created at și updated at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('failed_jobs');
    }
};

