<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('marker_scoring_profiles', function (Blueprint $table) {
            $table->id();

            $table->string('slug')->unique();
            $table->string('name');

            $table->string('profile_type')->default('general');

            $table->string('gender')->nullable();
            $table->unsignedSmallInteger('age_min')->nullable();
            $table->unsignedSmallInteger('age_max')->nullable();

            $table->boolean('pregnant')->nullable();

            $table->jsonb('risk_factors')->nullable();
            $table->jsonb('conditions')->nullable();

            $table->text('description')->nullable();
            $table->string('source')->nullable();

            $table->boolean('is_default')->default(false);
            $table->boolean('is_active')->default(true);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('marker_scoring_profiles');
    }
};