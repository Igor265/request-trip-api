<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TravelStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('travel_statuses')->insert([
            ['status_name' => 'solicitado'],
            ['status_name' => 'aprovado'],
            ['status_name' => 'cancelado'],
        ]);
    }
}
