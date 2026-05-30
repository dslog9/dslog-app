<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('user_checklists', function (Blueprint $table) {
            $table->unsignedBigInteger('test_panel_id')->nullable()->after('checklist_id');
            $table->index('test_panel_id');
        });
    }

    public function down(): void
    {
        Schema::table('user_checklists', function (Blueprint $table) {
            $table->dropIndex(['test_panel_id']);
            $table->dropColumn('test_panel_id');
        });
    }
};