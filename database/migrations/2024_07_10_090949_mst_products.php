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
        Schema::dropIfExists('mst_products');
        Schema::create('mst_products', function (Blueprint $table) {
            $table->increments('id', 10);
            $table->string('product_id', 10)->unique();
            $table->string('product_name')->unique();
            $table->string('description');
            $table->integer('product_price', autoIncrement:false);
            $table->string('product_image');
            $table->tinyInteger('is_sales', autoIncrement:false);
            $table->timestamp('created_at')->nullable();
            $table->integer('created_by', autoIncrement:false)->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->integer('updated_by', autoIncrement:false)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mst_products');
    }
};
