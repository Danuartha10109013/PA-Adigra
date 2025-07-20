<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Office;

class CheckOfficeCoordinates extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'office:check-coordinates';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check office coordinates and radius';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $offices = Office::all();

        if ($offices->isEmpty()) {
            $this->error('Tidak ada data kantor yang ditemukan!');
            return;
        }

        $this->info('=== DATA KOORDINAT KANTOR ===');
        $this->newLine();

        foreach ($offices as $office) {
            $this->line("ID: {$office->id}");
            $this->line("Nama: {$office->name}");
            $this->line("Alamat: {$office->address}");
            $this->line("Latitude: {$office->latitude}");
            $this->line("Longitude: {$office->longitude}");
            $this->line("Radius: {$office->radius} meter");
            $this->line("Dibuat: {$office->created_at}");
            $this->line("Diupdate: {$office->updated_at}");
            $this->newLine();
            $this->line('---');
            $this->newLine();
        }

        $this->info('Untuk mengupdate koordinat, gunakan menu Data Kantor di aplikasi web.');
    }
}
