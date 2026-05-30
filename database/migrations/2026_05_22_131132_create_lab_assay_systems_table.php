<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('lab_assay_systems', function (Blueprint $table) {
            $table->id();

            $table->string('slug')->unique();

            $table->string('name');

            $table->string('lab_name')->nullable();
            $table->string('method')->nullable();
            $table->string('analyzer')->nullable();
            $table->string('reagent')->nullable();

            $table->string('specimen_type')->nullable();
            $table->string('unit')->nullable();

            $table->string('source')->nullable();
            $table->text('note')->nullable();

            $table->boolean('is_default')->default(false);
            $table->boolean('is_active')->default(true);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lab_assay_systems');
    }
};