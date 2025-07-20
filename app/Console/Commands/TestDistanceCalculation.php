<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Office;

class TestDistanceCalculation extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:distance {lat} {lng}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test distance calculation between user coordinates and office';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $userLat = $this->argument('lat');
        $userLng = $this->argument('lng');

        $office = Office::first();

        if (!$office) {
            $this->error('Tidak ada data kantor yang ditemukan!');
            return;
        }

        $this->info('=== TEST PERHITUNGAN JARAK ===');
        $this->newLine();

        $this->line("Koordinat User: {$userLat}, {$userLng}");
        $this->line("Koordinat Kantor: {$office->latitude}, {$office->longitude}");
        $this->line("Radius Kantor: {$office->radius} meter");
        $this->newLine();

        // Perhitungan jarak menggunakan rumus Haversine
        $earthRadius = 6371; // km
        $latFrom = deg2rad($userLat);
        $lonFrom = deg2rad($userLng);
        $latTo = deg2rad($office->latitude);
        $lonTo = deg2rad($office->longitude);

        $latDelta = $latTo - $latFrom;
        $lonDelta = $lonTo - $lonFrom;

        $a = sin($latDelta / 2) * sin($latDelta / 2) +
             cos($latFrom) * cos($latTo) *
             sin($lonDelta / 2) * sin($lonDelta / 2);
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        $distanceKm = $earthRadius * $c;
        $distanceMeter = $distanceKm * 1000;
        $radiusKm = $office->radius / 1000;

        $this->line("Jarak yang dihitung: " . round($distanceMeter, 2) . " meter (" . round($distanceKm, 4) . " km)");
        $this->line("Radius kantor: " . $office->radius . " meter (" . round($radiusKm, 4) . " km)");
        $this->newLine();

        if ($distanceKm <= $radiusKm) {
            $this->info("✅ DAPAT ABSEN - User berada dalam radius kantor");
        } else {
            $this->error("❌ TIDAK DAPAT ABSEN - User berada di luar radius kantor");
            $this->line("Kelebihan jarak: " . round(($distanceMeter - $office->radius), 2) . " meter");
        }

        $this->newLine();
        $this->info('Untuk mendapatkan koordinat Anda, buka Google Maps dan klik kanan pada lokasi Anda.');
    }
}
