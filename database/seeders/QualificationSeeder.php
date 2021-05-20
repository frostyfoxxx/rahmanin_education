<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class QualificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('qualification_classifier')->insert([
            'specialty_id' => 1,
            'qualification' => 'Техник по компьютерным системам'
        ]);
        DB::table('qualification_classifier')->insert([
            'specialty_id' => 2,
            'qualification' => 'Сетевой и системный администратор'
        ]);
        DB::table('qualification_classifier')->insert([
            'specialty_id' => 3,
            'qualification' => 'Программист'
        ]);
        DB::table('qualification_classifier')->insert([
            'specialty_id' => 3,
            'qualification' => 'Разработчик веб и мультимедийных приложений'
        ]);
        DB::table('qualification_classifier')->insert([
            'specialty_id' => 3,
            'qualification' => 'Специалист по информационным системам'
        ]);
        DB::table('qualification_classifier')->insert([
            'specialty_id' => 4,
            'qualification' => 'Техник по защите информации'
        ]);
        DB::table('qualification_classifier')->insert([
            'specialty_id' => 5,
            'qualification' => 'Техник'
        ]);
        DB::table('qualification_classifier')->insert([
            'specialty_id' => 6,
            'qualification' => 'Техник'
        ]);
        DB::table('qualification_classifier')->insert([
            'specialty_id' => 7,
            'qualification' => 'Наладчик контрольно-измерительных приборов и автоматики'
        ]);
        DB::table('qualification_classifier')->insert([
            'specialty_id' => 7,
            'qualification' => 'Техник по компьютерным системам'
        ]);
        DB::table('qualification_classifier')->insert([
            'specialty_id' => 7,
            'qualification' => 'Слесарь контрольно-измерительных приборов и автоматики'
        ]);
        DB::table('qualification_classifier')->insert([
            'specialty_id' => 8,
            'qualification' => 'Электромеханик по торговому и холодильному оборудованию'
        ]);
        DB::table('qualification_classifier')->insert([
            'specialty_id' => 1,
            'qualification' => 'Техник по компьютерным системам'
        ]);
    }
}
