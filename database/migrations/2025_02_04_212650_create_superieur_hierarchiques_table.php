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
        Schema::create('superieur_hierarchiques', function (Blueprint $table) {
           $table->id();
    $table->string('nom');
    $table->string('prenom');
    $table->unsignedBigInteger('service_id');
    $table->unsignedBigInteger('employe_id');
    $table->foreign('service_id')->references('id')->on('services')->onDelete('cascade');
    $table->foreign('employe_id')->references('id')->on('employes')->onDelete('cascade');
    $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('superieur_hierarchiques');
    }
};