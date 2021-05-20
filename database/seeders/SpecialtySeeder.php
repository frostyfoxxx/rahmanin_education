<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SpecialtySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('specialty_classifier')->insert([
            'code' => "09.02.01",
            'specialty' => "Компьютерные системы и комплексы"
        ]);
        DB::table('specialty_classifier')->insert([
            'code' => "09.02.06",
            'specialty' => "Сетевое и системное администрирование"
        ]);
        DB::table('specialty_classifier')->insert([
            'code' => "09.02.07",
            'specialty' => "Информационные системы и программирование"
        ]);
        DB::table('specialty_classifier')->insert([
            'code' => "10.02.05",
            'specialty' => "Обеспечение информационной безопасности автоматизированных систем"
        ]);
        DB::table('specialty_classifier')->insert([
            'code' => "13.02.11",
            'specialty' => "Техническая эксплуатация и обслуживание электрического и электромеханического оборудования (по отраслям)"
        ]);
        DB::table('specialty_classifier')->insert([
            'code' => "15.02.14",
            'specialty' => "Оснащение средствами автоматизации технологических процессов и производств (по отраслям)"
        ]);
        DB::table('specialty_classifier')->insert([
            'code' => "15.01.31",
            'specialty' => "Мастер контрольно-измерительных приборов и автоматики"
        ]);
        DB::table('specialty_classifier')->insert([
            'code' => "15.01.17",
            'specialty' => "Электромеханик по торговому и холодильному оборудованию"
        ]);

    }
}
