<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Meeting Ditolak: {{ $meet->title }}</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f8f9fa; color: #222; }
        .container { background: #fff; max-width: 600px; margin: 30px auto; border-radius: 8px; box-shadow: 0 2px 8px #0001; padding: 32px; }
        h2 { color: #dc3545; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 24px; }
        th, td { text-align: left; padding: 8px 0; }
        th { width: 160px; color: #555; }
        .info { background: #e9ecef; border-radius: 6px; padding: 12px 16px; margin-bottom: 18px; }
        .footer { color: #888; font-size: 0.95em; margin-top: 32px; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Meeting Ditolak</h2>
        <div class="info">
            <table>
                <tr><th>Judul</th><td>{{ $meet->title }}</td></tr>
                <tr><th>Tanggal</th><td>{{ \Carbon\Carbon::parse($meet->date)->translatedFormat('l, d F Y') }}</td></tr>
                <tr><th>Waktu Mulai</th><td>{{ $meet->start }}</td></tr>
                <tr><th>Waktu Selesai</th><td>{{ $meet->end }}</td></tr>
                <tr><th>Kategori</th><td>{{ ucfirst(str_replace('_', ' ', $meet->category)) }}</td></tr>
                @isset($sender)
                <tr><th>Pengaju</th><td>{{ $sender->name }} ({{ $sender->email }})</td></tr>
                @endisset
            </table>
        </div>
        <p>Mohon maaf, pengajuan meeting Anda <b>ditolak</b> oleh admin. Silakan hubungi admin untuk informasi lebih lanjut atau ajukan ulang jika diperlukan.</p>
        <div class="footer">
            Terima kasih,<br>
            {{ config('app.name') }}<br>
            <small>Email ini dikirim otomatis oleh sistem.</small>
        </div>
    </div>
</body>
</html> 