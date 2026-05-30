<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_checklist_items', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('user_checklist_id');
            $table->unsignedBigInteger('marker_id');

            $table->integer('frequency_months')->nullable();

            $table->timestamp('last_tested_at')->nullable();
            $table->timestamp('next_due_at')->nullable();

            $table->string('status')->default('not_done');
            // not_done / done / overdue / needs_control

            $table->unsignedBigInteger('last_analysis_item_id')->nullable();

            $table->text('note')->nullable();

            $table->timestamps();

            $table->index('user_checklist_id');
            $table->index('marker_id');
            $table->index('status');
            $table->index('next_due_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_checklist_items');
    }
};