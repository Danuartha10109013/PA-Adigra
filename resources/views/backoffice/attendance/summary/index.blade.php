@extends('backoffice.layout.main')

@section('title', 'Rekapitulasi Absensi')

@section('content')

<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Rekapitulasi Absensi</h1>
        <div>
            {{-- <a href="{{ route('attendance.summary.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Tambah Rekapitulasi
            </a> --}}
            <a href="{{ url('backoffice/attendance/summary/report') }}" class="btn btn-info">
                <i class="fas fa-chart-bar"></i> Laporan
            </a>
        </div>
    </div>

    <!-- Filter Card -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="{{ route('attendance.summary.index') }}" method="GET" class="row g-3">
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
                    <a href="{{ route('attendance.summary.index') }}" class="btn btn-secondary">
                        <i class="fas fa-sync"></i> Reset
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Data Table -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Pegawai</th>
                            <th>Tanggal</th>
                            <th>Masuk</th>
                            <th>Pulang</th>
                            <th>Status</th>
                            <th>Keterangan</th>
                            <!-- <th>Aksi</th> -->
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($summaries as $summary)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $summary->user->name }}</td>
                                <td>{{ \Carbon\Carbon::parse($summary->date)->format('d/m/Y') }}</td>
                                <td>{{ $summary->check_in ? $summary->check_in->format('H:i') : '-' }}</td>
                                <td>{{ $summary->check_out ? $summary->check_out->format('H:i') : '-' }}</td>
                                <td>
                                    @if($summary->is_late)
                                        <span class="badge bg-warning">Terlambat</span>
                                    @elseif($summary->is_early_leave)
                                        <span class="badge bg-info">Pulang Awal</span>
                                    @elseif($summary->is_absent)
                                        <span class="badge bg-danger">Tidak Masuk</span>
                                    @elseif($summary->is_leave)
                                        <span class="badge bg-success">Cuti</span>
                                    @else
                                        <span class="badge bg-primary">Hadir</span>
                                    @endif
                                </td>
                                <td>{{ $summary->notes ?? '-' }}</td>
                                <!-- <td>
                                    <div class="btn-group">
                                        <a href="{{ url('backoffice/attendance/summary/edit/'.$summary->id) }}" class="btn btn-sm btn-info">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="{{ url('backoffice/attendance/summary/delete/'.$summary->id) }}" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </div>
                                </td> -->
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center">Tidak ada data</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            {{-- <div class="d-flex justify-content-end mt-3">
                {{ $summaries->links() }}
            </div> --}}
        </div>
    </div>
</div>
@endsection

@push('styles')
<link href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" rel="stylesheet">
@endpush

@push('scripts')
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
<script>
    $(document).ready(function() {
        $('#dataTable').DataTable({
            "paging": false,
            "ordering": true,
            "info": false,
            "searching": true
        });
    });
</script>
@endpush 