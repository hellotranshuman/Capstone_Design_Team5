<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderOptionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_option', function (Blueprint $table) {
            $table->unsignedInteger('op_num');
            $table->unsignedInteger('subop_num')->nullable();
            $table->unsignedInteger('order_menu_id');
            $table->foreign('op_num')
                ->references('opnum')->on('menu_option');
            $table->foreign('subop_num')
                ->references('sub_opnum')->on('suboption');
            $table->foreign('order_menu_id')
                ->references('id')->on('order_menu')
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
        Schema::dropIfExists('order_option');
    }
}
