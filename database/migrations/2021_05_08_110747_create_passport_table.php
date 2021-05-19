<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePassportTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('passport', function (Blueprint $table) {
            $table->id();
            $table->integer('series');
            $table->integer('number');
            $table->date('date_of_issue');
            $table->string('issued_by');
            $table->date('date_of_birth');
            $table->string('male');
            $table->string('place_of_birth');
            $table->string('registration_address');
            $table->boolean('lack_of_citizenship');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
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
        Schema::dropIfExists('passport');
    }
}
