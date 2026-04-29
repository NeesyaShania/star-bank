<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DepositoTypeSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('deposito_types')->insert([
            [
                'id' => 'DEP-001', 
                'name' => 'Bronze', 
                'yearly_return' => 3.0, 
                'created_at' => Carbon::now(), 
                'updated_at' => Carbon::now()
            ],
            [
                'id' => 'DEP-002', 
                'name' => 'Silver', 
                'yearly_return' => 5.0, 
                'created_at' => Carbon::now(), 
                'updated_at' => Carbon::now()
            ],
            [
                'id' => 'DEP-003', 
                'name' => 'Gold', 
                'yearly_return' => 7.0, 
                'created_at' => Carbon::now(), 
                'updated_at' => Carbon::now()
            ],
        ]);
    }
}