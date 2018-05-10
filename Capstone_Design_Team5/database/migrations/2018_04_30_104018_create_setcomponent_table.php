<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSetcomponentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('setcomponent', function (Blueprint $table) {
            $table->increments('component_id');
            $table->unsignedInteger('set_id');
            $table->unsignedInteger('menu_id');
            $table->foreign('set_id')
                ->references('set_id')->on('setmenu')
                ->onDelete('cascade');
            $table->foreign('menu_id')
                ->references('id')->on('menu')
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
        Schema::dropIfExists('setcomponent');
    }
}
