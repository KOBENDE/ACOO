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
        Schema::create('gestionnaire_rhs', function (Blueprint $table) {
            $table->id();
    $table->string('nom');
    $table->string('prenom');
    $table->unsignedBigInteger('employe_id');
    $table->foreign('employe_id')->references('id')->on('employes')->onDelete('cascade');
    $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gestionnaire_rhs');
    }
};