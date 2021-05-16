<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdditionalEducationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('additional_education', function (Blueprint $table) {
            $table->id();
            $table->string('form_of_education');
            $table->string('name_of_educational_institution');
            $table->string('number_of_diploma');
            $table->string('year_of_ending');
            $table->string('qualification');
            $table->string('specialty');
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
        Schema::dropIfExists('additional_education');
    }
}
