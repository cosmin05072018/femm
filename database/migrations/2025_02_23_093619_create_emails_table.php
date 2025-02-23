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
        Schema::create('emails', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('message_id')->unique(); // ID unic al emailului
            $table->string('from');
            $table->string('to');
            $table->string('subject')->nullable();
            $table->text('body')->nullable();
            $table->boolean('is_seen')->default(false);
            $table->json('attachments')->nullable(); // Salvăm atașamentele în format JSON
            $table->string('type');
            $table->timestamps();


            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('emails');
    }
};
