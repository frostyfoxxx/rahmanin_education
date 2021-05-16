<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
class CreateSchoolTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('school', function (Blueprint $table) {
            $table->id();
            $table->string('school_name');
            $table->string('number_of_classes');
            $table->string('year_of_ending');
            $table->string('number_of_certificate');
            $table->string('number_of_photo');
            $table->string('version_of_the_certificate');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
//            $table->primary(['user_id']);
        });
//        DB::table('school')->insert([
//            [
//                'school_name' => 'МБОУ СОШ №22',
//                'number_of_classes' => '9',
//                'year_of_ending' => '2018',
//                'number_of_certificate' => '1212121',
//            ]
//        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('school');
    }
}
