<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('analysis_item_evaluations', function (Blueprint $table) {
            $table->id();

            $table->foreignId('analysis_item_id')->constrained()->cascadeOnDelete();
            $table->foreignId('marker_id')->nullable()->constrained()->nullOnDelete();

            $table->foreignId('marker_scoring_profile_id')
                ->nullable()
                ->constrained('marker_scoring_profiles')
                ->nullOnDelete();

            $table->foreignId('marker_scoring_rule_id')
                ->nullable()
                ->constrained('marker_scoring_rules')
                ->nullOnDelete();

            $table->string('status')->default('unknown');
            $table->string('direction')->nullable();

            $table->decimal('value', 12, 4)->nullable();
            $table->string('unit')->nullable();

            $table->jsonb('applied_thresholds')->nullable();
            $table->jsonb('explanation')->nullable();

            $table->timestamps();

            $table->index(['analysis_item_id', 'status']);
            $table->index(['marker_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('analysis_item_evaluations');
    }
};