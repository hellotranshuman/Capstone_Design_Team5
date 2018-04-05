<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCouponTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coupon', function (Blueprint $table) {
            $table->increments('id');
            $table->string('category');
            $table->unsignedInteger('shop_id');
            $table->string('name');
            $table->integer('discount');
            $table->unsignedInteger('user_num');
            $table->unsignedInteger('price_condition');
            $table->boolean('price_check');
            $table->boolean('use_check');
            $table->dateTime('start_date');
            $table->dateTime('expiry_date');
            $table->timestamps();
            $table->foreign('user_num')
                ->references('id')->on('users')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('coupon');
    }
}
