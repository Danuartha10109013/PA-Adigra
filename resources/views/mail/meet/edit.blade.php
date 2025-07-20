@component('mail::message')
# Undangan Rapat: {{ $meet->title }}

## Detail Rapat
@if($oldMeet)
### Jadwal Sebelumnya
- **Judul:** {{ $oldMeet->title }}
- **Tanggal:** {{ \Carbon\Carbon::parse($oldMeet->date)->translatedFormat('l, d F Y') }}
- **Waktu Mulai:** {{ $oldMeet->start }}
- **Waktu Selesai:** {{ $oldMeet->end }}

### Jadwal Terbaru
@endif
- **Judul:** {{ $meet->title }}
- **Tanggal:** {{ \Carbon\Carbon::parse($meet->date)->translatedFormat('l, d F Y') }}
- **Waktu Mulai:** {{ $meet->start }}
- **Waktu Selesai:** {{ $meet->end }}

{{-- @component('mail::button', ['url' => config('app.url')])
Lihat Rapat
@endcomponent --}}

Kami berharap kehadiran Anda.

Terima kasih,
{{ config('app.name') }}
@endcomponent