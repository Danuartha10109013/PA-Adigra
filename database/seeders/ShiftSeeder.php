<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ShiftSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('shifts')->insert([
            'name' => 'Jam Kerja',
            'start' => '08:00:00',
            'end' => '16:00:00',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
