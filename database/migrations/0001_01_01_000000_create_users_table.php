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
        $table->id();

        $table->string('first_name', 50);
        $table->string('last_name', 50);
        $table->string('middle_name', 100)->nullable();
        $table->string('email', 100)->unique();
        $table->timestamp('email_verified_at')->nullable();
        $table->string('password');
        $table->string('phone_no', 20)->nullable();
        $table->text('address')->nullable();
        $table->string('bvn', 20)->nullable();
        $table->string('nin', 20)->nullable();
        $table->string('photo', 255)->nullable();
        $table->string('profile_photo_url', 255)->nullable();
        $table->enum('role', ['user', 'agent', 'admin'])->default('user');
        $table->enum('status', ['active', 'inactive', 'suspended'])->default('active');
        $table->datetime('last_login')->nullable();
        $table->rememberToken();
        $table->timestamps();
    });



        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
