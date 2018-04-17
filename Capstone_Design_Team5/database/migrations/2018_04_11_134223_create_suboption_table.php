<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSuboptionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('suboption', function (Blueprint $table) {
            $table->increments('sub_opnum');
            $table->unsignedInteger('opnum');
            $table->string('name');
            $table->foreign('opnum')
                ->references('opnum')->on('menu_option')
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
        Schema::dropIfExists('suboption');
    }
}
