<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommuBookmarkTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('commu_bookmark', function (Blueprint $table) {
            $table->increments('bookmark_num');
            $table->unsignedInteger('user_num');
            $table->unsignedInteger('emoticon_num');
            $table->foreign('user_num')
                ->references('id')->on('users')
                ->onDelete('cascade');
            $table->foreign('emoticon_num')
                ->references('id')->on('communication')
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
        Schema::dropIfExists('commu_bookmark');
    }
}
