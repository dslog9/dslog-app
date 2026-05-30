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
        Schema::create('user_checklists', function (Blueprint $table) {
    $table->id();

    $table->foreignId('user_id')->constrained()->cascadeOnDelete();
    $table->foreignId('checklist_id')->constrained()->cascadeOnDelete();
    $table->foreignId('last_analysis_id')->nullable()->constrained('analyses')->nullOnDelete();

    $table->string('status')->default('pending'); // pending / completed / overdue / skipped

    $table->timestamp('assigned_at')->nullable();
    $table->timestamp('completed_at')->nullable();

    $table->text('notes')->nullable();

    $table->timestamps();

    $table->unique(['user_id', 'checklist_id']);
    $table->index('status');
    $table->index('completed_at');
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_checklists');
    }
};
