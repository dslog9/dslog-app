<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('marker_profile_applicability', function (Blueprint $table) {
            $table->id();

            $table->foreignId('marker_id')
                ->constrained('markers')
                ->cascadeOnDelete();

            $table->foreignId('scoring_profile_id')
                ->constrained('marker_scoring_profiles')
                ->cascadeOnDelete();

            $table->boolean('is_primary')->default(false);
            $table->unsignedInteger('priority')->default(100);

            $table->string('reason')->nullable();
            $table->text('note')->nullable();

            $table->boolean('is_active')->default(true);

            $table->timestamps();

            $table->unique([
                'marker_id',
                'scoring_profile_id',
            ], 'marker_profile_applicability_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('marker_profile_applicability');
    }
};