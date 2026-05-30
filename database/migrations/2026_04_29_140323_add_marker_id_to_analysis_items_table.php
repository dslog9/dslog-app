<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('analysis_items', function (Blueprint $table) {
            $table->unsignedBigInteger('marker_id')->nullable()->after('analysis_id');
            $table->index('marker_id');
        });
    }

    public function down(): void
    {
        Schema::table('analysis_items', function (Blueprint $table) {
            $table->dropIndex(['marker_id']);
            $table->dropColumn('marker_id');
        });
    }
};