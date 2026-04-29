<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            DepositoTypeSeeder::class,
            AdminSeeder::class, 
        ]);
        
        $this->call([
            DepositoTypeSeeder::class,
        ]);
    }
}