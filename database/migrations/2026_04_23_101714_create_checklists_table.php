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
        Schema::create('checklists', function (Blueprint $table) {
    $table->id();

    $table->string('title');
    $table->text('description')->nullable();

    $table->string('gender')->nullable();       // male / female / any
    $table->integer('age_from')->nullable();
    $table->integer('age_to')->nullable();

    $table->string('risk_level')->nullable();   // low / medium / high
    $table->string('category')->nullable();     // например blood, hormone, screening

    $table->integer('frequency_value')->nullable();
    $table->string('frequency_unit')->nullable(); // month / year

    $table->boolean('is_active')->default(true);

    $table->timestamps();

    $table->index('gender');
    $table->index('risk_level');
    $table->index('is_active');
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('checklists');
    }
};
