<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('test_panel_faqs', function (Blueprint $table) {
            $table->id();

            $table->foreignId('test_panel_id')
                ->constrained('test_panels')
                ->cascadeOnDelete();

            $table->text('question');
            $table->text('answer');

            $table->unsignedInteger('sort_order')->default(100);
            $table->boolean('is_active')->default(true);

            $table->timestamps();

            $table->index(['test_panel_id', 'sort_order']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('test_panel_faqs');
    }
};