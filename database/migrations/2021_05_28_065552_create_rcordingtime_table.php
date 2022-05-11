<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRcordingtimeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recordingtime', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('daterecording_id');
            $table->time('recording_start');
            $table->time('recording_ends');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->timestamps();

            $table->foreign('daterecording_id')->references('id')->on('recordingdates')->cascadeOnDelete()->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('recordingtime');
    }
}
