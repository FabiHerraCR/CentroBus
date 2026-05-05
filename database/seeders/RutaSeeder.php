<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RutaSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('rutas')->insert([
            ['origen' => 'CR',  'destino' => 'NI',  'horario' => '03:00:00', 'precio' => 80],
            ['origen' => 'CR',  'destino' => 'ES',  'horario' => '06:00:00', 'precio' => 120],
            ['origen' => 'CR',  'destino' => 'GUA', 'horario' => '06:00:00', 'precio' => 140],
            ['origen' => 'CR',  'destino' => 'NI',  'horario' => '06:00:00', 'precio' => 80],
            ['origen' => 'CR',  'destino' => 'HN',  'horario' => '06:00:00', 'precio' => 110],
            ['origen' => 'CR',  'destino' => 'PN',  'horario' => '05:00:00', 'precio' => 80],

            ['origen' => 'PN',  'destino' => 'CR',  'horario' => '08:00:00', 'precio' => 80],

            ['origen' => 'GUA', 'destino' => 'CR',  'horario' => '05:00:00', 'precio' => 140],
            ['origen' => 'GUA', 'destino' => 'ES',  'horario' => '05:00:00', 'precio' => 80],
            ['origen' => 'GUA', 'destino' => 'HN',  'horario' => '05:00:00', 'precio' => 110],
            ['origen' => 'GUA', 'destino' => 'NI',  'horario' => '05:00:00', 'precio' => 120],

            ['origen' => 'NI',  'destino' => 'CR',  'horario' => '03:00:00', 'precio' => 80],
            ['origen' => 'NI',  'destino' => 'CR',  'horario' => '06:00:00', 'precio' => 80],
        ]);
    }
}