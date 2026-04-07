<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
          $table->string('username', 50)->primary();
            $table->string('password_hashed', 255);

            $table->string('email', 100)->unique();
            $table->string('phone_number', 20)->nullable();

            $table->enum('role', [
                'member',
                'doctor',
                'facility_admin',
                'admin'
            ])->default('member');

            $table->enum('status', [
                'active',
                'suspended'
            ])->default('active');

            $table->timestamp('last_login_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
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
