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
        Schema::create('books', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title', 255)->charset('utf8mb4')->collation('utf8mb4_unicode_ci');
            $table->string('author', 50)->charset('utf8mb4')->collation('utf8mb4_unicode_ci');
            $table->dateTime('published_date');
            $table->string('description', 1000)->charset('utf8mb4')->collation('utf8mb4_unicode_ci');
            $table->tinyInteger('status')->default(0)->comment('0-Available,1-Borrowed,2-Inactive');
            $table->timestamps(); // created_at and updated_at
            $table->index('status', 'Idx_book_status');
            $table->index('author', 'Idx_book_author');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
