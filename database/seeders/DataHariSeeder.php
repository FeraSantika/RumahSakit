<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DataHariSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $dataHari = [
            ['nama_hari' => 'Senin'],
            ['nama_hari' => 'Selasa'],
            ['nama_hari' => 'Rabu'],
            ['nama_hari' => 'Kamis'],
            ['nama_hari' => "Jum'at"],
            ['nama_hari' => 'Sabtu'],
            ['nama_hari' => 'Minggu'],
        ];

        DB::table('data_hari')->insert($dataHari);
    }
}
