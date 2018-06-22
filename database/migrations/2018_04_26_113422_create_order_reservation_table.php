<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderReservationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reservation', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('shop_id');
            $table->unsignedInteger('user_num')->nullable();
            $table->dateTime('reservation_date');
            $table->unsignedInteger('person');
            $table->unsignedInteger('child');
            $table->string('reservation_name', 50)->nullable();
            $table->string('message')->nullable();
            $table->boolean('menu_select');
            $table->boolean('accept')->nullable();
            $table->unsignedInteger('order_num')->nullable();
            $table->string('refused_message')->nullable();
            $table->foreign('user_num')
                ->references('id')->on('users')
                ->onDelete('cascade');
            $table->foreign('shop_id')
                ->references('id')->on('restaurants')
                ->onDelete('cascade');
            $table->foreign('order_num')
                ->references('order_num')->on('order_list')
                ->onDelete('cascade');
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
        Schema::dropIfExists('order_reservation');
    }
}
