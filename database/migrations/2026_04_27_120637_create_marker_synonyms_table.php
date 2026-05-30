<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('marker_synonyms', function (Blueprint $table) {
            $table->id();

            $table->foreignId('marker_id')->constrained('markers')->cascadeOnDelete();
            $table->string('name');

            $table->timestamps();

            $table->index('name');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('marker_synonyms');
    }
};