<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OfficeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        DB::table('offices')->insert([
            [
                'name' => 'Office 1',
                'address' => 'Jl. Office 1',
                'latitude' => -6.239021126082432,
                'longitude' => 106.80143005655052,
                'radius' => 400,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
