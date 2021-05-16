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
        Schema::create('first_parent', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('middle_name');
            $table->string('last_name');
            $table->string('phoneNumber');
        });
        Schema::create('second_parent', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('middle_name');
            $table->string('last_name');
            $table->string('phoneNumber');

        });
        Schema::create('parent', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('first_parent_id');
            $table->unsignedBigInteger('second_parent_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('first_parent_id')->references('id')->on('first_parent');
            $table->foreign('second_parent_id')->references('id')->on('second_parent');
//            $table->primary(['user_id','first_parent_id','second_parent_id']);
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
        Schema::dropIfExists('first_parent');
        Schema::dropIfExists('second_parent');
        Schema::dropIfExists('parent');
    }
}
