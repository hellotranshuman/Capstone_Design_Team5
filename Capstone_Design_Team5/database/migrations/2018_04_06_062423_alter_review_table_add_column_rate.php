<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterReviewTableAddColumnRate extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('review', function (Blueprint $table) {
            $table->unsignedInteger('taste')->nullable();
            $table->unsignedInteger('service')->nullable();
            $table->unsignedInteger('mood')->nullable();
            $table->unsignedInteger('price')->nullable();
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
