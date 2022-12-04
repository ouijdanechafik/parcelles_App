<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class VillageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('villages')->insert([
            [
                'id' => 1,
                'nom' => "Bouskoura",
            ],
            [
                'id' => 2,
                'nom' => "Nouaceur",
            ],
            [
                'id' => 3,
                'nom' => "Aïn Harrouda",
            ],
            [
                'id' => 4,
                'nom' => "Taghazout",
            ],
            [
                'id' => 5,
                'nom' => "Tagounite",
            ],
            [
                'id' => 6,
                'nom' => "Khamlia",
            ],
        ]);
    }
}
