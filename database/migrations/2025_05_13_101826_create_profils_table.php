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
        Schema::create('profils', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->timestamps();
            $table->string('poste', 255);
            $table->string('etude', 255);
            $table->string('experience', 255);
            $table->string('civilite', 255);
            $table->string('nom', 255);
            $table->string('prenom', 255);
            $table->string('naissance', 255);
            $table->string('adresse', 255);
            $table->string('email', 255);
            $table->string('contact', 255);
            $table->text('descriptionProfil');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profils');
    }
};
