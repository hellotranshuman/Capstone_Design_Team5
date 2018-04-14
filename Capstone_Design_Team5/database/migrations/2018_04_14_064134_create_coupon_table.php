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
            $table->integer('discount')->nullable();
            $table->unsignedInteger('price_condition')->nullable();
            $table->unsignedInteger('add_product')->nullable();
            $table->dateTime('start_date');
            $table->dateTime('expiry_date');
            $table->timestamps();
            $table->foreign('add_product')
                ->references('id')->on('menu')
                ->onDelete('cascade');
            $table->foreign('shop_id')
                ->references('id')->on('restaurants')
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
