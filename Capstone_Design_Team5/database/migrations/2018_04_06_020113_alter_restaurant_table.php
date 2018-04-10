<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterRestaurantTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('restaurants', function (Blueprint $table) {
            $table->dropColumn('lunch_open');
            $table->dropColumn('lunch_close');
            $table->dropColumn('lunch_lo');
            $table->dropColumn('dinner_open');
            $table->dropColumn('dinner_close');
            $table->dropColumn('dinner_lo');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
