<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShopLikeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shop_like', function (Blueprint $table) {
            $table->unsignedInteger('user_num');
            $table->unsignedInteger('shop_id');
            $table->timestamps();
            $table->foreign('user_num')
                ->references('id')->on('users')
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
        Schema::dropIfExists('shop_like');
    }
}
