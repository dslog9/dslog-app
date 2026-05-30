<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('analyses', function (Blueprint $table) {
            $table->string('document_type')->default('unknown')->after('source_type');

            $table->unsignedInteger('detected_items_count')->default(0)->after('document_type');

            $table->string('classification_reason')->nullable()->after('detected_items_count');
        });
    }

    public function down(): void
    {
        Schema::table('analyses', function (Blueprint $table) {
            $table->dropColumn([
                'document_type',
                'detected_items_count',
                'classification_reason',
            ]);
        });
    }
};