<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProprietaireSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('proprietaires')->insert([
            [
                'id' => 1,
                'nom' => Str::random(10),
                'prenom' => Str::random(10),
                'sexe' => "femme",
                'nationalite' => 'Marocaine',
                'type_identite' => 'CIN',
                'numero_identite' => 'TT23334',
                'adresse' => 'Paris Rue Place Alphonse Humbert ',
            
            ],
            [
                'id' => 2,
                'nom' => Str::random(10),
                'prenom' => Str::random(10),
                'sexe' => "femme",
                'nationalite' => 'Marocaine',
                'type_identite' => 'CIN',
                'numero_identite' => 'RE23334',
                'adresse' => 'Paris Rue Place Alphonse Humbert ',
            
            ],
            [
                'id' => 3,
                'nom' => Str::random(10),
                'prenom' => Str::random(10),
                'sexe' => "homme",
                'nationalite' => 'Marocaine',
                'type_identite' => 'Passport',
                'numero_identite' => 'EE2456634',
                'adresse' => 'Paris Rue Place Alphonse Humbert ',
            
            ],
        ]
    );
    }
}
