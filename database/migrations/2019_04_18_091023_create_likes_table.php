<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLikesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('likes', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
      //   $table->unsignedInteger('user_id');
                // $table->unsignedInteger('plan_id');

                $table->integer('user_id')->unsigned();
                $table->integer('plan_id')->unsigned();


                $table->integer('likes_count')->default(0);
                $table->softDeletes();
                $table->foreign('user_id')->references('id')->on('users');
                $table->foreign('plan_id')->references('id')->on('plans');

            });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('likes');
    }
}
