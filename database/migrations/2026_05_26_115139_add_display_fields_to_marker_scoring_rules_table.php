<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('marker_scoring_rules', function (Blueprint $table) {
            //
        });

                Schema::table('marker_scoring_rules', function (Blueprint $table) {
            $table->unsignedTinyInteger('display_precision')->nullable()->after('direction');
            $table->string('zone_mode')->default('bands')->after('display_precision');
            $table->string('health_direction')->default('range_is_better')->after('zone_mode');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('marker_scoring_rules', function (Blueprint $table) {
            //
        });
        Schema::table('marker_scoring_rules', function (Blueprint $table) {
            $table->dropColumn([
                'display_precision',
                'zone_mode',
                'health_direction',
            ]);
        });
    }
};
