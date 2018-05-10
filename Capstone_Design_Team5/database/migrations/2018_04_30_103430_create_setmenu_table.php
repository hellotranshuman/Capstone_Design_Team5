<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSetmenuTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('setmenu', function (Blueprint $table) {
            $table->increments('set_id');
            $table->unsignedInteger('shop_id');
            $table->string('set_name', 100);
            $table->string('explanation')->nullable();
            $table->unsignedInteger('price');
            $table->timestamps();
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
        Schema::dropIfExists('setmenu');
    }
}
