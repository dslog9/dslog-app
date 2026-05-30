<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('test_panel_markers', function (Blueprint $table) {
            $table->id();

            $table->foreignId('test_panel_id')->constrained('test_panels')->cascadeOnDelete();
            $table->foreignId('marker_id')->constrained('markers')->cascadeOnDelete();

            $table->integer('priority')->default(100);
            $table->text('note')->nullable();

            $table->timestamps();

            $table->unique(['test_panel_id', 'marker_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('test_panel_markers');
    }
};