<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('marker_ranges', function (Blueprint $table) {
            $table->id();

            $table->foreignId('marker_id')->constrained('markers')->cascadeOnDelete();

            $table->string('gender')->nullable(); // male, female, any
            $table->integer('age_min')->nullable();
            $table->integer('age_max')->nullable();

            $table->decimal('min_value', 10, 3)->nullable();
            $table->decimal('max_value', 10, 3)->nullable();

            $table->string('unit')->nullable();
            $table->string('status_type')->default('normal'); // normal, borderline, critical
            $table->text('note')->nullable();
            $table->string('source')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('marker_ranges');
    }
};