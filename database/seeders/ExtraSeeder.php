<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ExtraSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Extra::create([
            'name' => 'Extra syr',
            'price' => 5.00,
        ]);

        Extra::create([
            'name' => 'Extra mäso',
            'price' => 7.00,
        ]);

        Extra::create([
            'name' => 'Extra feferóny',
            'price' => 3.00,
        ]);
    }
}
