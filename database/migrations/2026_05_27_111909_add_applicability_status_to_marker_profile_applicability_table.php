<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('marker_profile_applicability', function (Blueprint $table) {
            $table->string('applicability_status')
                ->default('needs_review')
                ->after('scoring_profile_id');
        });
    }

    public function down(): void
    {
        Schema::table('marker_profile_applicability', function (Blueprint $table) {
            $table->dropColumn('applicability_status');
        });
    }
};