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
        Schema::create('analyses', function (Blueprint $table) {
    $table->id();

    $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();

    $table->string('source_type'); // text | image | pdf
    $table->string('file_path')->nullable();

    $table->longText('extracted_text')->nullable();

    $table->text('summary')->nullable();
    $table->text('details')->nullable();

    $table->json('risks')->nullable();
    $table->json('recommendations')->nullable();

    $table->json('raw_ai_response')->nullable();

    $table->timestamp('analyzed_at')->nullable();

    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('analyses');
    }
};
