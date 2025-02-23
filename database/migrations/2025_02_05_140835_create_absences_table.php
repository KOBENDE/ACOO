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
         Schema::create('absence_requests', function (Blueprint $table) {
             $table->id();
             $table->unsignedBigInteger('user_id'); // Employé qui fait la demande
             $table->string('leave_type'); // Type de congé
             $table->date('start_date'); // Date de début
             $table->time('start_time')->nullable(); // Heure de début (si nécessaire)
             $table->date('end_date'); // Date de fin
             $table->time('end_time')->nullable(); // Heure de fin (si nécessaire)
             $table->text('comment')->nullable(); // Commentaire de l'employé
             $table->string('status')->default('pending'); // Statut de la demande (pending, approved, rejected)
             $table->unsignedBigInteger('approved_by')->nullable(); // Manager qui approuve
             $table->datetime('decision_date')->nullable(); // Date d'approbation/rejet
             $table->text('rejection_reason')->nullable(); // Raison du rejet
             $table->string('attachment')->nullable(); // Document justificatif
             $table->integer('priority_level')->default(0); // Priorité de la demande
             $table->unsignedBigInteger('updated_by')->nullable();       // Modifications effectuées par
             $table->foreign('updated_by')->references('id')->on('users')->onDelete('cascade');
             $table->timestamps(); // created_at et updated_at
         });
     }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('absence_requests');
    }
};
