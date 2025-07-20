@component('mail::message')
# Undangan Rapat: {{ $meet->title }}

## Detail Rapat
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
