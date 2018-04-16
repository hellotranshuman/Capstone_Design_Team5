<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRestaurentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('restaurants', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->unsignedInteger('user_num');
            $table->string('type', 30);
            $table->text('explanation');
            $table->string('phone');
            $table->string('dodobuken');
            $table->string('cities');
            $table->string('address');;
            $table->time('lunch_open');
            $table->time('lunch_close');
            $table->time('lunch_lo');
            $table->time('dinner_open');
            $table->time('dinner_close');
            $table->time('dinner_lo');
            $table->string('payment');
            $table->unsignedInteger('seat_num');
            $table->boolean('children');
            $table->boolean('pet');
            $table->boolean('parking');
            $table->boolean('smoking');
            $table->boolean('privateroom');
            $table->unsignedInteger('selectLayout')->default('1');
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
        Schema::dropIfExists('restaurent');
    }
}
