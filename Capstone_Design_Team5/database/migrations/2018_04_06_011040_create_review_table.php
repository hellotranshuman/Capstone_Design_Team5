<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReviewTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('review', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('shop_id');
            $table->text('content');
            $table->dateTime('reg_date');
            $table->unsignedInteger('writer');
            $table->double('rating');
            $table->unsignedInteger('taste');
            $table->unsignedInteger('service');
            $table->unsignedInteger('mood');
            $table->unsignedInteger('price');
            $table->unsignedInteger('img_num')->default('0');
            $table->timestamps();
            $table->foreign('writer')
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
        Schema::dropIfExists('review');
    }
}
