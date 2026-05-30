<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('test_panel_markers', function (Blueprint $table) {
            $table->integer('frequency_months')->nullable()->after('priority');
        });
    }

    public function down(): void
    {
        Schema::table('test_panel_markers', function (Blueprint $table) {
            $table->dropColumn('frequency_months');
        });
    }
};