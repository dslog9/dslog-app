<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('test_panel_content_block_items', function (Blueprint $table) {
            $table->id();

            $table->foreignId('test_panel_content_block_id')
                ->constrained('test_panel_content_blocks')
                ->cascadeOnDelete();

            $table->string('title');
            $table->text('description')->nullable();

            $table->unsignedInteger('sort_order')->default(100);
            $table->json('meta')->nullable();

            $table->timestamps();

            $table->index(['test_panel_content_block_id', 'sort_order']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('test_panel_content_block_items');
    }
};