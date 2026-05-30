<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('markers', function (Blueprint $table) {
            if (!Schema::hasColumn('markers', 'seo_title')) {
                $table->string('seo_title')->nullable();
            }

            if (!Schema::hasColumn('markers', 'seo_description')) {
                $table->text('seo_description')->nullable();
            }

            if (!Schema::hasColumn('markers', 'seo_intro')) {
                $table->text('seo_intro')->nullable();
            }

            if (!Schema::hasColumn('markers', 'h1')) {
                $table->string('h1')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('markers', function (Blueprint $table) {
            if (Schema::hasColumn('markers', 'seo_title')) {
                $table->dropColumn('seo_title');
            }

            if (Schema::hasColumn('markers', 'seo_description')) {
                $table->dropColumn('seo_description');
            }

            if (Schema::hasColumn('markers', 'seo_intro')) {
                $table->dropColumn('seo_intro');
            }

            if (Schema::hasColumn('markers', 'h1')) {
                $table->dropColumn('h1');
            }
        });
    }
};