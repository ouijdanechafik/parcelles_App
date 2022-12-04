<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use DateTime;

class ParcelleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('parcelles')->insert(
            [
                [
                'user_id' => 2,
                'proprietaire_id' => 3,
                'numero' => 45,
                'date_delimation' => new DateTime(),
                'village_id'=> 3,
                'signature' => Str::random(10),
                ],
                [
                    'user_id' => 1,
                    'proprietaire_id' => 2,
                    'numero' => 254,
                    'date_delimation' => new DateTime(),
                    'village_id'=> 4,
                    'signature' => Str::random(10),
                ],
                [
                    'user_id' => 2,
                    'proprietaire_id' => 3,
                    'numero' => 455,
                    'date_delimation' => new DateTime(),
                    'village_id'=> 6,
                    'signature' => Str::random(10),
                ],
        
        
    
    ]);
    }
}
