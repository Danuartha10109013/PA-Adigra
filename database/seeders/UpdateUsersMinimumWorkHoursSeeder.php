<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UpdateUsersMinimumWorkHoursSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Update semua user yang belum memiliki minimum_work_hours
        User::whereNull('minimum_work_hours')
            ->orWhere('minimum_work_hours', 0)
            ->update(['minimum_work_hours' => 5]);

        $this->command->info('Berhasil mengupdate jam kerja minimal untuk semua user menjadi 5 jam');
    }
}
