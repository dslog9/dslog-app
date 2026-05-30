<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('markers', function (Blueprint $table) {
            $table->json('norms')->nullable();
            $table->json('low')->nullable();
            $table->json('high')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('markers', function (Blueprint $table) {
            $table->dropColumn(['norms', 'low', 'high']);
        });
    }
};