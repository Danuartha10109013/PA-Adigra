<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\LeaveQuota;

class ResetLeaveQuota extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'leave-quota:reset';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reset jatah cuti semua karyawan di awal tahun';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $tahun = date('Y');
        $users = User::all();
        $count = 0;
        
        foreach ($users as $user) {
            $exists = LeaveQuota::where('user_id', $user->id)->where('year', $tahun)->exists();
            if (!$exists) {
                LeaveQuota::create([
                    'user_id' => $user->id,
                    'year' => $tahun,
                    'quota' => 30, // 30 hari per tahun
                    'used' => 0,
                ]);
                $count++;
            }
        }
        
        $this->info("Jatah cuti tahun $tahun berhasil direset untuk $count karyawan.");
    }
} 