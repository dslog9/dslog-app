<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('marker_reference_ranges', function (Blueprint $table) {
            $table->id();

            $table->foreignId('marker_id')->constrained()->cascadeOnDelete();
            $table->foreignId('lab_assay_system_id')->nullable()->constrained()->nullOnDelete();

            $table->string('gender')->default('any');
            $table->unsignedSmallInteger('age_min')->nullable();
            $table->unsignedSmallInteger('age_max')->nullable();

            $table->boolean('pregnant')->nullable();

            $table->decimal('min_value', 12, 4)->nullable();
            $table->decimal('max_value', 12, 4)->nullable();
            $table->string('unit')->nullable();

            $table->string('range_type')->default('reference');

            $table->string('source')->nullable();
            $table->text('note')->nullable();

            $table->boolean('is_active')->default(true);

            $table->timestamps();

            $table->index(['marker_id', 'gender', 'age_min', 'age_max']);
            $table->index(['marker_id', 'lab_assay_system_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('marker_reference_ranges');
    }
};