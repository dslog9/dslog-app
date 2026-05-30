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
        Schema::table('test_panel_markers', function (Blueprint $table) {
            $table->string('role')
                ->default('core')
                ->after('is_required');
        });

        Schema::table('user_checklists', function (Blueprint $table) {
            $table->string('variant')
                ->default('basic')
                ->after('test_panel_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('test_panel_markers', function (Blueprint $table) {
            $table->dropColumn('role');
        });

        Schema::table('user_checklists', function (Blueprint $table) {
            $table->dropColumn('variant');
        });
    }
};