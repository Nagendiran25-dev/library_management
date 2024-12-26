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
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 255)->charset('utf8mb4')->collation('utf8mb4_unicode_ci');
            $table->string('email', 255)->charset('utf8mb4')->collation('utf8mb4_unicode_ci')->unique();
            $table->unsignedBigInteger('mobile_number')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password', 255)->charset('utf8mb4')->collation('utf8mb4_unicode_ci');
            $table->enum('role', ['user', 'admin'])->default('user')->charset('utf8mb4')->collation('utf8mb4_unicode_ci');
            $table->tinyInteger('status')->default(0)->comment('0-Active, 1-Inactive');
            $table->string('remember_token', 100)->charset('utf8mb4')->collation('utf8mb4_unicode_ci')->nullable();
            $table->timestamps(); // created_at and updated_at

            // Indexes
            $table->index('status', 'Idx_user_status');
            $table->index('role', 'Idx_user_role');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
