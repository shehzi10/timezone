<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('product_name')->nullable();
            $table->string('brand_id')->nullable();
            $table->string('category_id')->nullable();
            $table->string('color_id')->nullable();
            $table->string('price')->nullable();
            $table->string('gender')->nullable();
            $table->string('style')->nullable();
            $table->string('image')->nullable();
            $table->string('case_material')->nullable();
            $table->string('description')->nullable();
            $table->string('condition')->nullable();
            $table->string('weight')->nullable();
            $table->boolean('availability')->default(0);
            $table->string('popular_watch')->default(0);
            $table->integer('discount_id')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
};
