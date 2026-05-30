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
        Schema::create('analysis_items', function (Blueprint $table) {
    $table->id();

    $table->foreignId('analysis_id')->constrained()->cascadeOnDelete();

    $table->string('marker_code')->nullable();     // например HGB
    $table->string('marker_name');                 // hemoglobin
    $table->string('marker_label')->nullable();    // Гемоглобин

    $table->decimal('value', 10, 2)->nullable();   // числовое значение
    $table->string('value_text')->nullable();      // если не число

    $table->string('unit')->nullable();            // g/L, mmol/L
    $table->string('reference_range')->nullable(); // 120-160

    $table->string('status')->nullable();          // low / normal / high

    $table->integer('sort_order')->nullable();

    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('analysis_items');
    }
};
