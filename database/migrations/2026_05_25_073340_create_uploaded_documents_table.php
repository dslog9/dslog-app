<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('uploaded_documents', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();

            $table->string('document_type')->default('unknown');
            $table->string('source_type')->default('text');

            $table->string('original_filename')->nullable();
            $table->string('file_path')->nullable();
            $table->string('mime_type')->nullable();
            $table->unsignedBigInteger('file_size')->nullable();

            $table->longText('extracted_text')->nullable();

            $table->unsignedInteger('detected_items_count')->default(0);
            $table->string('classification_confidence')->nullable();
            $table->text('classification_reason')->nullable();

            $table->jsonb('metadata')->nullable();

            $table->timestamps();

            $table->index(['user_id', 'document_type']);
            $table->index(['source_type']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('uploaded_documents');
    }
};