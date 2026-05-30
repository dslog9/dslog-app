<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('test_panels', function (Blueprint $table) {
            $table->string('category')->nullable()->after('description');
            $table->string('gender')->nullable()->after('category');
            $table->integer('age_min')->nullable()->after('gender');
            $table->integer('age_max')->nullable()->after('age_min');
            $table->text('short_description')->nullable()->after('age_max');
            $table->integer('sort_order')->default(100)->after('short_description');
            $table->boolean('is_active')->default(true)->after('sort_order');
        });
    }

    public function down(): void
    {
        Schema::table('test_panels', function (Blueprint $table) {
            $table->dropColumn([
                'category',
                'gender',
                'age_min',
                'age_max',
                'short_description',
                'sort_order',
                'is_active',
            ]);
        });
    }
};