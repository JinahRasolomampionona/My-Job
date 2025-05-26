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
        Schema::create('formations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->timestamps();
            $table->string('anneeScolaire', 255);
            $table->string('diplome', 255);
            $table->string('etablissement', 255);
            $table->text('descriptionFormation');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('formations');
    }
};
