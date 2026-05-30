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
       

	Schema::table('user_checklists', function (Blueprint $table) {
	    $table->timestamp('due_at')->nullable()->after('assigned_at');
	    $table->string('result_status')->nullable()->after('status'); // ok / warning / critical / unknown
	});


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        

	Schema::table('user_checklists', function (Blueprint $table) {
	    $table->dropColumn(['due_at', 'result_status']);
	});


    }
};
