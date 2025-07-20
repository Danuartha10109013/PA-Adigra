@component('mail::message')
# Pembatalan Rapat

## Jadwal Rapat yang Dibatalkan
- **Judul:** {{ $title }}
- **Tanggal:** {{ \Carbon\Carbon::parse($date)->translatedFormat('l, d F Y') }}
- **Waktu Mulai:** {{ $start }}
- **Waktu Selesai:** {{ $end }}

Rapat ini telah dibatalkan karena jadwalnya telah dihapus.

Terima kasih,
{{ config('app.name') }}
@endcomponent
