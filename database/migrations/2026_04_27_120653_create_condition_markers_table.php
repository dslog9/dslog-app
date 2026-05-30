<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('condition_markers', function (Blueprint $table) {
            $table->id();

            $table->foreignId('condition_id')->constrained('conditions')->cascadeOnDelete();
            $table->foreignId('marker_id')->constrained('markers')->cascadeOnDelete();

            $table->string('direction')->nullable(); // low, high, abnormal
            $table->integer('weight')->default(100);
            $table->text('note')->nullable();

            $table->timestamps();

            $table->unique(['condition_id', 'marker_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('condition_markers');
    }
};