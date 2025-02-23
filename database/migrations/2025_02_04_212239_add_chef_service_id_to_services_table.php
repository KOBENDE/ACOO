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
        Schema::table('services', function (Blueprint $table) {
            //les champs ajouter
            $table->unsignedBigInteger('chef_service_id')->nullable()->after('nom');
            $table->foreign('chef_service_id')->references('id')->on('employes')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('services', function (Blueprint $table) {
            //
            $table->dropForeign(['chef_service_id']);
            $table->dropColumn('chef_service_id');
        });
    }
};