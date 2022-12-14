<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'id' => 1,
            'name' => 'ouijdane',
            'email' => Str::random(10).'@gmail.com',
            'password' => Hash::make('password'),
            'username' => 'Ouijdanechafik',
            'role'=> 'admin'
        ]);
        DB::table('users')->insert([
            'id' => 2,
            'name' => 'Amina',
            'email' => Str::random(10).'@gmail.com',
            'password' => Hash::make('password'),
            'username' => 'Amine32',
            'role'=> 'agent'
        ]);
    }
}
