@extends('backoffice.layout.main')

@section('title', 'Laporan Rekapitulasi Absensi')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4 no-print">
        <h1 class="h3 mb-0 text-gray-800">Laporan Rekapitulasi Absensi</h1>
        <div>
            <button onclick="window.print()" class="btn btn-primary">
                <i class="fas fa-print"></i> Cetak
            </button>
            <a href="{{ route('attendance.summary.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali ke Rekapitulasi
            </a>
        </div>
    </div>

    <!-- Filter Card -->
    <div class="card shadow mb-4 no-print">
        <div class="card-body">
            <form action="{{ route('attendance.summary.report') }}" method="GET" class="row g-3">
                <div class="col-md-3">
                    <label class="form-label">Tanggal Mulai</label>
                    <input type="date" class="form-control" name="start_date" value="{{ request('start_date') }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Tanggal Akhir</label>
                    <input type="date" class="form-control" name="end_date" value="{{ request('end_date') }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Pegawai</label>
                    <select class="form-select" name="user_id">
                        <option value="">Semua Pegawai</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>
                                {{ $user->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary me-2">
                        <i class="fas fa-search"></i> Filter
                    </button>
                    <a href="{{ route('attendance.summary.report') }}" class="btn btn-secondary">
                        <i class="fas fa-sync"></i> Reset
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Report Card -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="reportTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th rowspan="2" class="align-middle">No</th>
                            <th rowspan="2" class="align-middle">Nama Pegawai</th>
                            <th colspan="2" class="text-center">Kehadiran</th>
                            <th colspan="2" class="text-center">Keterlambatan</th>
                            <th colspan="2" class="text-center">Pulang Awal</th>
                            <th colspan="2" class="text-center">Tidak Masuk</th>
                            <th colspan="2" class="text-center">Cuti</th>
                        </tr>
                        <tr>
                            <th class="text-center">Hadir</th>
                            <th class="text-center">%</th>
                            <th class="text-center">Jumlah</th>
                            <th class="text-center">%</th>
                            <th class="text-center">Jumlah</th>
                            <th class="text-center">%</th>
                            <th class="text-center">Jumlah</th>
                            <th class="text-center">%</th>
                            <th class="text-center">Jumlah</th>
                            <th class="text-center">%</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($report as $index => $data)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $data['user']->name }}</td>
                                <td class="text-center">{{ $data['total_days'] - $data['total_absent'] - $data['total_leave'] }}</td>
                                <td class="text-center">
                                    {{ number_format(($data['total_days'] - $data['total_absent'] - $data['total_leave']) / $data['total_days'] * 100, 1) }}%
                                </td>
                                <td class="text-center">{{ $data['total_late'] }}</td>
                                <td class="text-center">
                                    {{ number_format($data['total_late'] / $data['total_days'] * 100, 1) }}%
                                </td>
                                <td class="text-center">{{ $data['total_early_leave'] }}</td>
                                <td class="text-center">
                                    {{ number_format($data['total_early_leave'] / $data['total_days'] * 100, 1) }}%
                                </td>
                                <td class="text-center">{{ $data['total_absent'] }}</td>
                                <td class="text-center">
                                    {{ number_format($data['total_absent'] / $data['total_days'] * 100, 1) }}%
                                </td>
                                <td class="text-center">{{ $data['total_leave'] }}</td>
                                <td class="text-center">
                                    {{ number_format($data['total_leave'] / $data['total_days'] * 100, 1) }}%
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="12" class="text-center">Tidak ada data</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<link href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" rel="stylesheet">
<style>
    @media print {
        /* Sembunyikan elemen yang tidak perlu */
        .no-print {
            display: none !important;
        }
        
        /* Reset style card */
        .card {
            border: none !important;
            box-shadow: none !important;
        }
        
        .card-body {
            padding: 0 !important;
        }
        
        /* Style tabel */
        table {
            width: 100% !important;
            border-collapse: collapse !important;
        }
        
        th, td {
            border: 1px solid #000 !important;
            padding: 8px !important;
            font-size: 12px !important;
        }
        
        th {
            background-color: #f8f9fa !important;
            -webkit-print-color-adjust: exact !important;
        }
        
        /* Reset container */
        .container-fluid {
            width: 100% !important;
            padding: 0 !important;
            margin: 0 !important;
        }
        
        /* Hapus DataTables elements */
        .dataTables_length, .dataTables_filter, .dataTables_info, .dataTables_paginate {
            display: none !important;
        }
    }
</style>
@endpush

@push('scripts')
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
<script>
    $(document).ready(function() {
        $('#reportTable').DataTable({
            "paging": false,
            "ordering": true,
            "info": false,
            "searching": true
        });
    });
</script>
@endpush 