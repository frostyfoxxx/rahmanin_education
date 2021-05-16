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
            $table->string('series');
            $table->string('number');
            $table->string('date_of_issue');
            $table->string('issued_by');
            $table->string('date_of_birth');
            $table->string('male');
            $table->string('place_of_birth');
            $table->string('address_of_birth');
            $table->string('lack_of_citizenship');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
//            $table->primary(['user_id']);
//            $table->timestamps();
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
