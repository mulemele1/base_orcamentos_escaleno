<?php
// database/seeders/DatabaseSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            ModulosSeeder::class,
            CapitulosSeeder::class,
            ActividadesSeeder::class,
            GruposSeeder::class,
            ComponentesSeeder::class,
            PrecosMateriaisSeeder::class,
        ]);
    }
}