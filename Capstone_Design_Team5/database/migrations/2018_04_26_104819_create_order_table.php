<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_list', function (Blueprint $table) {
            $table->increments('order_num');
            $table->unsignedInteger('shop_id');
            $table->unsignedInteger('user_num');
            $table->dateTime('order_date');
            $table->foreign('user_num')
                ->references('id')->on('users')
                ->onDelete('cascade');
            $table->foreign('shop_id')
                ->references('id')->on('restaurants')
                ->onDelete('cascade');
            $table->unsignedInteger('total');
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
        Schema::dropIfExists('order');
    }
}
