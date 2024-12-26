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
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Foreign key to users table
            $table->foreignId('book_id')->constrained()->onDelete('cascade'); // Foreign key to books table
            $table->dateTime('borrowed_date');
            $table->dateTime('due_date');
            $table->dateTime('return_date')->nullable();
            $table->decimal('fine_amount', 8, 2)->nullable(); // Fine amount for late return
            $table->timestamps(); // created_at, updated_at timestamps
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
