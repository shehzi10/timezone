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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('order_id');
            $table->string('payment_method_id');
            $table->tinyText('address');
            $table->double('sub_total');
            $table->integer('vat_percent')->nullable();
            $table->double('vat_amount')->nullable();
            $table->double('discount_amount')->nullable();
            $table->double('total');
            $table->enum('b_pickup', ['0', '1'])->default('0');
            $table->string('charge_id');
            $table->tinyText('blc_transaction_id');
            $table->enum('status', ['in-process', 'cancel', 'complete', 'refund', 'on-hold', 'out-for-delivery'])->default('in-process');
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
        Schema::dropIfExists('orders');
    }
};
