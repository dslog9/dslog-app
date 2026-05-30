<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('test_panels', function (Blueprint $table) {

            $table->string('panel_type')
                ->default('checkup')
                ->after('category');

            $table->string('thematic_type')
                ->nullable()
                ->after('panel_type');

        });
    }

    public function down(): void
    {
        Schema::table('test_panels', function (Blueprint $table) {

            $table->dropColumn([
                'panel_type',
                'thematic_type',
            ]);

        });
    }
};