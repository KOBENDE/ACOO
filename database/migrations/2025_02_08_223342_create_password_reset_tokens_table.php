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
    Schema::create('password_reset_tokens', function (Blueprint $table) {
        $table->string('email')->primary(); // Clé primaire
        $table->string('token'); // Token de réinitialisation
        $table->timestamp('created_at')->nullable(); // Date de création
    });
}

public function down()
{
    Schema::dropIfExists('password_reset_tokens');
}
};