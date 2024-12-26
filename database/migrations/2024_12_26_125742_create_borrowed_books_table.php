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
        Schema::create('borrowed_books', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('book_id');
            $table->dateTime('borrowed_date');
            $table->dateTime('due_date');
            $table->dateTime('return_date')->nullable();
            $table->decimal('fine_amount', 8, 2)->nullable();
            $table->tinyInteger('status')->default(1)->comment('0-Return, 1-Not Return');
            $table->timestamps(); // created_at and updated_at

            // Indexes
            $table->index('user_id', 'borrowed_books_user_id_foreign');
            $table->index('book_id', 'borrowed_books_book_id_foreign');

            // Foreign Keys
            $table->foreign('user_id', 'borrowed_books_user_id_foreign')
                  ->references('id')->on('users')
                  ->onDelete('cascade');
            $table->foreign('book_id', 'borrowed_books_book_id_foreign')
                  ->references('id')->on('books')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('borrowed_books');
    }
};
