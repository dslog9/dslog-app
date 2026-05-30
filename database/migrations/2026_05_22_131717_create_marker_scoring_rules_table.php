<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('marker_scoring_rules', function (Blueprint $table) {
            $table->id();

            $table->foreignId('marker_id')->constrained()->cascadeOnDelete();

            $table->foreignId('scoring_profile_id')
                ->constrained('marker_scoring_profiles')
                ->cascadeOnDelete();

            $table->string('direction')->default('range');

            $table->decimal('critical_low_max', 12, 4)->nullable();
            $table->decimal('needs_control_low_max', 12, 4)->nullable();
            $table->decimal('borderline_low_max', 12, 4)->nullable();

            $table->decimal('optimal_min', 12, 4)->nullable();
            $table->decimal('optimal_max', 12, 4)->nullable();

            $table->decimal('exceptional_min', 12, 4)->nullable();
            $table->decimal('exceptional_max', 12, 4)->nullable();

            $table->decimal('borderline_high_min', 12, 4)->nullable();
            $table->decimal('needs_control_high_min', 12, 4)->nullable();
            $table->decimal('critical_high_min', 12, 4)->nullable();

            $table->string('unit')->nullable();

            $table->string('source')->nullable();
            $table->text('note')->nullable();

            $table->boolean('is_active')->default(true);

            $table->timestamps();

            $table->index(['marker_id', 'scoring_profile_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('marker_scoring_rules');
    }
};