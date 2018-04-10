<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('category');
            $table->string('user_id', 50)->unique();
            $table->boolean('gender');
            $table->string('country', 30);
            $table->date('birthday');
            $table->string('favorite_1')->nullable();
            $table->string('favorite_2')->nullable();
            $table->string('favorite_3')->nullable();
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
