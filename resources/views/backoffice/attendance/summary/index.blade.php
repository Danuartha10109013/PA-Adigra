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
                <div class="col-md-3">
                    <label class="form-label">Jenis Absen</label>
                    <select class="form-select" name="jenis_absen">
                        <option value="">Semua</option>
                        <option value="wfo" {{ request('jenis_absen') == 'wfo' ? 'selected' : '' }}>WFO</option>
                        <option value="wfh" {{ request('jenis_absen') == 'wfh' ? 'selected' : '' }}>WFH</option>
                    </select>
                </div>
                <div class="col-md-12 d-flex align-items-end justify-content-end">
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
                            <th>Bukti Foto</th>
                            <!-- <th>Aksi</th> -->
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($absents as $absent)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $absent->user ? $absent->user->name : '-' }}</td>
                                <td>{{ \Carbon\Carbon::parse($absent->date)->format('d/m/Y') }}</td>
                                <td>{{ $absent->start ? \Carbon\Carbon::parse($absent->start)->format('H:i') : '-' }}</td>
                                <td>{{ $absent->end ? \Carbon\Carbon::parse($absent->end)->format('H:i') : '-' }}</td>
                                <td>
                                    @if(strtolower($absent->status) == 'wfh')
                                        <span class="badge bg-secondary">WFH</span>
                                    @elseif(strtolower($absent->status) == 'absen' || strtolower($absent->status) == 'wfo')
                                        <span class="badge bg-primary">WFO</span>
                                    @else
                                        <span class="badge bg-info">{{ ucfirst($absent->status) }}</span>
                                    @endif
                                </td>
                                <td>{{ $absent->description ?? '-' }}</td>
                                <td>
                                    @if($absent->bukti_foto && strtolower($absent->status) == 'wfh')
                                        <img src="{{ asset('storage/'.$absent->bukti_foto) }}" alt="Bukti WFH" style="max-width:60px; max-height:60px; border-radius:6px; border:1px solid #ccc; cursor:pointer;" onclick="showPreviewModalCustom('{{ asset('storage/'.$absent->bukti_foto) }}')">
                                        <script>
                                            function showPreviewModalCustom(imgUrl) {
                                                document.getElementById('customPreviewImage').src = imgUrl;
                                                document.getElementById('customPreviewModal').style.display = 'flex';
                                            }
                                            function closePreviewModalCustom() {
                                                document.getElementById('customPreviewModal').style.display = 'none';
                                            }
                                            var customModal = document.getElementById('customPreviewModal');
                                            if (customModal) {
                                                customModal.addEventListener('click', function(e) {
                                                    if (e.target === this) closePreviewModalCustom();
                                                });
                                            }
                                            </script>
                                        @else
                                        -
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center">Tidak ada data</td>
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
<!-- Custom Modal Preview Bukti Foto -->
<div id="customPreviewModal" style="display:none; position:fixed; z-index:9999; left:0; top:0; width:100vw; height:100vh; background:rgba(0,0,0,0.7); align-items:center; justify-content:center;">
    <div style="position:relative; background:transparent; display:flex; align-items:center; justify-content:center; width:100vw; height:100vh;">
        <img id="customPreviewImage" src="" alt="Preview Bukti WFH" style="max-width:98vw; max-height:95vh; border-radius:12px; border:4px solid #fff; box-shadow:0 0 30px #000; padding:12px; background:#fff;">
        <button onclick="closePreviewModalCustom()" style="position:absolute; top:30px; right:40px; background:#fff; border:none; border-radius:50%; width:48px; height:48px; font-size:2em; font-weight:bold; color:#333; cursor:pointer; box-shadow:0 2px 12px #0003;">&times;</button>
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