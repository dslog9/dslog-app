<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('marker_body_system', function (Blueprint $table) {
            $table->id();

            $table->foreignId('marker_id')->constrained('markers')->cascadeOnDelete();
            $table->foreignId('body_system_id')->constrained('body_systems')->cascadeOnDelete();

            $table->integer('priority')->default(100);
            $table->text('note')->nullable();

            $table->timestamps();

            $table->unique(['marker_id', 'body_system_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('marker_body_system');
    }
};