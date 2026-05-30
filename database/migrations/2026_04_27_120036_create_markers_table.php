<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('markers', function (Blueprint $table) {
            $table->id();

            $table->string('code')->unique(); // HGB, WBC и т.д.
            $table->string('slug')->unique();

            $table->string('name'); // Гемоглобин
            $table->string('title')->nullable();
            $table->string('h1')->nullable();

            $table->foreignId('group_id')->nullable()->constrained('marker_groups')->nullOnDelete();

            $table->text('description')->nullable();
            $table->text('seo_description')->nullable();
            $table->text('seo_intro')->nullable();

            $table->text('what_is')->nullable();
            $table->text('risks')->nullable();
            $table->text('what_to_do')->nullable();

            $table->text('when_to_test')->nullable();
            $table->text('preparation')->nullable();

            $table->string('unit')->nullable();

            $table->boolean('is_active')->default(true);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('markers');
    }
};