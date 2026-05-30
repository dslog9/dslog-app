<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('marker_relations', function (Blueprint $table) {
            $table->id();

            $table->foreignId('marker_id')->constrained('markers')->cascadeOnDelete();
            $table->foreignId('related_marker_id')->constrained('markers')->cascadeOnDelete();

            $table->string('relation_type')->default('related');
            // related, check_together, affects, confirms, excludes, follow_up

            $table->integer('priority')->default(100);
            $table->text('note')->nullable();

            $table->timestamps();

            $table->unique(['marker_id', 'related_marker_id', 'relation_type']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('marker_relations');
    }
};