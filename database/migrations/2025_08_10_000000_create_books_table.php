<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            // owner of record
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->string('author');
            $table->unsignedInteger('publication_year');
            $table->string('cover_path')->nullable();
            $table->timestamps();

            // prevent duplicates (title+author+year)
            $table->unique(['user_id','title','author','publication_year'],'uniq_owner_title_author_year');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
