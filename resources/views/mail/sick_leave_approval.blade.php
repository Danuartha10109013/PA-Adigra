<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Pengajuan Izin/Sakit Disetujui</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f8f9fa; color: #222; }
        .container { background: #fff; max-width: 600px; margin: 30px auto; border-radius: 8px; box-shadow: 0 2px 8px #0001; padding: 32px; }
        h2 { color: #198754; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 24px; }
        th, td { text-align: left; padding: 8px 0; }
        th { width: 160px; color: #555; }
        .info { background: #e9ecef; border-radius: 6px; padding: 12px 16px; margin-bottom: 18px; }
        .footer { color: #888; font-size: 0.95em; margin-top: 32px; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Pengajuan Izin/Sakit Anda Disetujui</h2>
        <div class="info">
            <table>
                <tr><th>Mulai</th><td>{{ $submission->start_date }}</td></tr>
                <tr><th>Selesai</th><td>{{ $submission->end_date }}</td></tr>
                <tr><th>Tipe</th><td>{{ ucfirst($submission->type) }}</td></tr>
                <tr><th>Alasan</th><td>{{ $submission->description }}</td></tr>
                @isset($approver)
                <tr><th>Disetujui Oleh</th><td>{{ $approver->name }} ({{ $approver->email }})</td></tr>
                @endisset
            </table>
        </div>
        <p>Pengajuan izin/sakit Anda telah <b>disetujui</b> oleh admin. Silakan cek jadwal Anda.</p>
        <div class="footer">
            Terima kasih,<br>
            {{ config('app.name') }}<br>
            <small>Email ini dikirim otomatis oleh sistem.</small>
        </div>
    </div>
</body>
</html> 