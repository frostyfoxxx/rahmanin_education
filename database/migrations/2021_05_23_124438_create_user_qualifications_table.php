<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserQualificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_qualifications', function (Blueprint $table) {

            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('qualification_id');
            $table->double('middlemark')->nullable();
            $table->string('form_education');
            $table->string('type_education')->comment('Бюджет/Коммерция');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('qualification_id')->references('id')->on('qualifications');
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
        Schema::dropIfExists('user_qualifications');
    }
}
