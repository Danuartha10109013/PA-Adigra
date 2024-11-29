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
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'name' => 'Direktur Operasional',
                'email' => 'direkturoperasional@gmail.com',
                'email_verified_at' => now(),
                'password' => Hash::make('Qwerty123'),
                'remember_token' => Str::random(40),
                'role_id' => 1,
                'office_id' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Karyawan',
                'email' => 'karyawan@gmail.com',
                'email_verified_at' => now(),
                'password' => Hash::make('Qwerty123'),
                'remember_token' => Str::random(40),
                'role_id' => 2,
                'office_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
