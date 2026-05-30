<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('test_panel_markers', function (Blueprint $table) {
            $table->integer('age_min')->nullable()->after('frequency_months');
            $table->integer('age_max')->nullable()->after('age_min');
            $table->string('gender')->nullable()->after('age_max');
            $table->boolean('is_required')->default(true)->after('gender');
            $table->text('reason')->nullable()->after('is_required');
        });
    }

    public function down(): void
    {
        Schema::table('test_panel_markers', function (Blueprint $table) {
            $table->dropColumn([
                'age_min',
                'age_max',
                'gender',
                'is_required',
                'reason',
            ]);
        });
    }
};