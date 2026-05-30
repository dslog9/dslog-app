<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('symptom_markers', function (Blueprint $table) {
            $table->id();

            $table->foreignId('symptom_id')->constrained('symptoms')->cascadeOnDelete();
            $table->foreignId('marker_id')->constrained('markers')->cascadeOnDelete();

            $table->integer('priority')->default(100);
            $table->text('reason')->nullable();
            $table->text('context')->nullable();

            $table->timestamps();

            $table->unique(['symptom_id', 'marker_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('symptom_markers');
    }
};