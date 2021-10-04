<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateParentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('first_parents', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('middle_name');
            $table->string('last_name');
            $table->string('phoneNumber');
            $table->timestamps();
        });
        Schema::create('second_parents', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('middle_name');
            $table->string('last_name');
            $table->string('phoneNumber');
            $table->timestamps();
        });
        Schema::create('parents', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('first_parent_id');
            $table->unsignedBigInteger('second_parent_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('first_parent_id')->references('id')->on('first_parents');
            $table->foreign('second_parent_id')->references('id')->on('second_parents');
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
        Schema::dropIfExists('parent');
        Schema::dropIfExists('first_parents');
        Schema::dropIfExists('second_parents');
    }
}
