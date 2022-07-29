<?php

use App\Models\Trade;
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
        Schema::create('trades', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable();
            $table->foreignId('brand_id');
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('model_num')->nullable();
            $table->string('model_name')->nullable();
            $table->string('model_price')->nullable();
            $table->enum('model_condition',['3','4','5','6','7','8','9','10'])->default('4');
            $table->string('comments')->nullable();
            $table->enum('packing',[Trade::PACKING_BOX, Trade::PACKING_PAPER, Trade::PACKING_BOXANDPAPER, Trade::PACKING_NONE])->default(Trade::PACKING_NONE);

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
        Schema::dropIfExists('trades');
    }
};
