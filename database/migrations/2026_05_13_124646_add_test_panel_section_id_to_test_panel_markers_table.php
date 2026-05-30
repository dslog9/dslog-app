<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('test_panel_markers', function (Blueprint $table) {

            $table->foreignId('test_panel_section_id')
                ->nullable()
                ->after('test_panel_id')
                ->constrained()
                ->nullOnDelete();

        });
    }

    public function down(): void
    {
        Schema::table('test_panel_markers', function (Blueprint $table) {

            $table->dropConstrainedForeignId('test_panel_section_id');

        });
    }
};