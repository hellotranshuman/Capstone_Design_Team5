<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRessetTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('resset', function (Blueprint $table) {
            $table->increments('resset_num');
            $table->unsignedInteger('shop_id');
            $table->date('setting_date');
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();
            $table->boolean('remark');
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
        Schema::dropIfExists('resset');
    }
}
