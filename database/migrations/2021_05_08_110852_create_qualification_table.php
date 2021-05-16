<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class   CreateQualificationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('number_of_seats', function (Blueprint $table) {
            $table->id();
            $table->integer('number_of_budget _seats');
            $table->integer('number_of_places_of_commerce');
//            $table->timestamps();
        });
        Schema::create('qualification', function (Blueprint $table) {
            $table->id();
            $table->string('qualification');
            $table->boolean('distance_learning');
            $table->boolean('full_time_education');
            $table->unsignedBigInteger('number_of_seats_id');
            $table->foreign('number_of_seats_id')->references('id')->on('number_of_seats');

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
        Schema::dropIfExists('qualification');
    }
}
