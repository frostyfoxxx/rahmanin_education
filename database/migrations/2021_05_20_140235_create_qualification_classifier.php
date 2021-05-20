<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQualificationClassifier extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('qualification_classifier', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('specialty_id');
            $table->string('qualification');
            $table->foreign('specialty_id')->references('id')->on('specialty_classifier');
            $table->timestamps();
        });;
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('qualification_classifier');
    }
}
