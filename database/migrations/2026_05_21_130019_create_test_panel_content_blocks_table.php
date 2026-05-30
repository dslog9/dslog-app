<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('test_panel_content_blocks', function (Blueprint $table) {
            $table->id();

            $table->foreignId('test_panel_id')
                ->constrained('test_panels')
                ->cascadeOnDelete();

            $table->string('type');
            $table->string('title');
            $table->text('description')->nullable();

            $table->unsignedInteger('sort_order')->default(100);
            $table->boolean('is_active')->default(true);

            $table->timestamps();

            $table->unique(['test_panel_id', 'type']);
            $table->index(['test_panel_id', 'sort_order']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('test_panel_content_blocks');
    }
};