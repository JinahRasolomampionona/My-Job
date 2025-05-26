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
        Schema::create('experiences', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->timestamps();
            $table->string('moisDebut', 255);
            $table->string('anneeDebut', 255);
            $table->string('moisFin', 255);
            $table->string('anneeFin', 255);
            $table->string('anneeExperience', 255);
            $table->string('societe', 255);
            $table->string('posteExperience', 255);
            $table->text('descriptionExperience');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('experiences');
    }
};
