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
            $table->id(); // Primary Key with Auto Increment
            $table->string('title', 255); // Title column with max length 255
            $table->string('author', 50); // Author column with max length 50
            $table->string('description', 1000); // Description column with max length 1000
            $table->datetime('published_date'); // Published datetime
            $table->timestamps(); // Created_at and Updated_at columns
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
