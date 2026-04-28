<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('users')->insert([
            'id' => 'ADM-001',
            'name' => 'Admin1',
            'email' => 'admin1@gmail.com',
            'pin' => Hash::make('123456'), 
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
    }
}