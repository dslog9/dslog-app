<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('markers', function (Blueprint $table) {
            if (!Schema::hasColumn('markers', 'short')) {
                $table->text('short')->nullable();
            }

            if (!Schema::hasColumn('markers', 'interpretation')) {
                $table->json('interpretation')->nullable();
            }
        });

        DB::statement('ALTER TABLE markers ALTER COLUMN low TYPE json USING low::json');
        DB::statement('ALTER TABLE markers ALTER COLUMN high TYPE json USING high::json');
        DB::statement('ALTER TABLE markers ALTER COLUMN what_to_do TYPE json USING to_json(what_to_do)');
    }

    public function down(): void
    {
        Schema::table('markers', function (Blueprint $table) {
            if (Schema::hasColumn('markers', 'short')) {
                $table->dropColumn('short');
            }

            if (Schema::hasColumn('markers', 'interpretation')) {
                $table->dropColumn('interpretation');
            }
        });

        DB::statement('ALTER TABLE markers ALTER COLUMN low TYPE text USING low::text');
        DB::statement('ALTER TABLE markers ALTER COLUMN high TYPE text USING high::text');
        DB::statement('ALTER TABLE markers ALTER COLUMN what_to_do TYPE text USING what_to_do::text');
    }
};