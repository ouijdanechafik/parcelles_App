<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class Photos_identiteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('photos_identites')->insert([
            [
              
                'src' => "img.jpg",
                'proprietaire_id' => 1,
            ],
            [
              
                'src' => "img1.jpg",
                'proprietaire_id' => 2,
            ],
            [
              
                'src' => "img2.jpg",
                'proprietaire_id' => 3,
            ],
           
        ]);
    }
}
