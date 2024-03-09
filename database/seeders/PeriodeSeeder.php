<?php

namespace Database\Seeders;

use App\Models\Periode;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PeriodeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $periode = [
            [
                'id' => 1,
                'periode_name' => 2022,
                'status' => 1,
            ],
            [
                'id' => 2,
                'periode_name' => 2023,
                'status' => 1,
            ],
            [
                'id' => 3,
                'periode_name' => 2024,
                'status' => 1,
            ],
        ];

        Periode::query()->insert($periode);
    }
}
