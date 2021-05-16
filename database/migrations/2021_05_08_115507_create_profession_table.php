<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProfessionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
//        Schema::create('profession', function (Blueprint $table) {
//            $table->id();
//            $table->unsignedBigInteger('user_id');
//            $table->unsignedBigInteger('specialty_id');
//            $table->unsignedBigInteger('qualification_id');
//            $table->foreign('user_id')->references('id')->on('users');
//            $table->foreign('specialty_id')->references('id')->on('specialty');
//            $table->foreign('qualification_id')->references('id')->on('qualification');
////            $table->primary(['user_id','specialty_id','qualification_id']);
////            $table->timestamps();
//        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('profession');
    }
}
