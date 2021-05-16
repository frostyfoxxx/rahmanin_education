<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('phone_number');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
//            $table->timestamps();
        });
//        DB::table('users')->insert([
//            [
//                'first_name'=>'Роздольский',
//                'middle_name'=>'Андрей',
//                'last_name'=>'Александрович',
//                'phone_number'=>'+79617984103',
//                'email'=>'aaaaaaa@mail.ru',
//                'password'=>'123456',
////                'api_token'=>Str::random(35),
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
        Schema::dropIfExists('users');
    }
}

