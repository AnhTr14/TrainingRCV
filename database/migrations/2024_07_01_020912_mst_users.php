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
        Schema::dropIfExists('mst_users');
        Schema::create('mst_users', function (Blueprint $table) {
            $table->increments('id', 10);
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->rememberToken('remember_token')->nullable();
            $table->string('verify_email', 100)->nullable();
            $table->tinyInteger('is_active', autoIncrement:false)->default(1);
            $table->tinyInteger('is_delete', autoIncrement:false)->default(0);
            $table->string('group_role', 50);
            $table->timestamp('last_login_at')->nullable();
            $table->string('last_login_ip', 40)->nullable();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();

            $table->index('name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mst_users');
    }
};
