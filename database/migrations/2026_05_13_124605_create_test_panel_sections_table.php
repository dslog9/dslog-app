<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('test_panel_sections', function (Blueprint $table) {
            $table->id();

            $table->foreignId('test_panel_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->string('slug');
            $table->string('name');

            $table->text('description')->nullable();

            $table->integer('priority')->default(100);

            $table->integer('frequency_months')->nullable();

            $table->boolean('is_required')->default(true);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('test_panel_sections');
    }
};