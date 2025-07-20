@extends('backoffice.layout.main')

@section('content')

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Data Jadwal Meeting</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item active">Data Jadwal Meeting</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<section class="content">

    <div class="row justify-content-center">
        <div class="col-md-12">

            <div class="card card-outline card-primary">
                
                <div class="card-header">
                    <h3 class="card-title">Meeting</h3>

                    <div class="card-tools">
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#tambah">
                            <i class="fas fa-plus"></i> Tambah Meeting
                        </button>
                        <button type="button" class="btn btn-tool btn-sm" data-card-widget="collapse"
                            data-toggle="tooltip" title="Collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>

                <div class="card-body">

                    @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Berhasil </strong>{{ session('success') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    @endif

                    @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Error! </strong>{{ session('error') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    @endif

                    <table class="table table-bordered table-hover text-center" id="example1">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Judul</th>
                                <th>Tanggal</th>
                                <th>Waktu</th>
                                <th>Kategori</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach($meets as $key => $meet)
                            <tr>
                            <tr class="meeting-row" data-start="{{ \Carbon\Carbon::parse($meet->date . ' ' .        $meet->start) }}" data-end="{{ \Carbon\Carbon::parse($meet->date . ' ' . $meet->end) }}">
                            <td>{{ $key+1 }}</td>
                            <td>{{ $meet->title }}</td>
                            <td>{{ \Carbon\Carbon::parse($meet->date)->translatedFormat('l, d F Y') }}</td>
                            <td>{{ $meet->start }} - {{ $meet->end }}</td>
                            <td>
                                @if($meet->category == 'internal')
                                    <span class="badge badge-info">Meeting Internal</span>
                                @elseif($meet->category == 'online')
                                    <span class="badge badge-primary">Meeting Online</span>
                                @else
                                    <span class="badge badge-warning">Meeting Keluar Kota</span>
                                @endif
                            </td>
                            <td class="status">
                                @if($meet->status == 'pending')
                                    <span class="badge badge-warning">Pending</span>
                                @elseif($meet->status == 'onboarding')
                                    <span class="badge badge-info">Onboarding</span>
                                @else
                                    <span class="badge badge-success">Selesai</span>
                                @endif
                            </td>
                                <td>
                                    @if($meet->status == 'pending')
                                        <form action="{{ route('meet.complete', $meet->id) }}" method="POST" style="display: inline;">
                                            @csrf
                                            <button type="submit" class="btn btn-success btn-sm" onclick="return confirm('Apakah meeting ini sudah selesai?')" title="Selesai">
                                                <i class="fas fa-check"></i>
                                            </button>
                                        </form>
                                        <button class="btn btn-info btn-sm" data-toggle="modal" data-target="#notulensi{{ $meet->id }}" title="Notulensi">
                                            <i class="fas fa-file-alt"></i>
                                        </button>
                                    @endif
                                    
                                    @if(Auth::user()->role_id == 1)
                                        @if($meet->status !== 'completed')

                                            <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#edit-{{ $meet->id }}" title="Ubah">
                                                <i class="fa fa-edit"></i>
                                            </button>
                                        @endif
                                        <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#delete-{{ $meet->id }}" title="Hapus">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    {{-- modal --}}
                    @foreach ($meets as $meet)
                    @include('backoffice.meet.modal.edit')
                    @include('backoffice.meet.modal.delete')
                    @include('backoffice.meet.modal.notulensi')
                    @endforeach

                </div>

            </div>

        </div>
    </div>

</section>
<script>
    setInterval(function () {
        $.ajax({
            url: "{{ route('meetings.updateStatus') }}",
            method: "GET",
            success: function (response) {
                console.log("Status meeting berhasil diperbarui.");
                // Optional: reload halaman agar status baru tampil
                // location.reload();
            },
            error: function (err) {
                console.error("Gagal update status meeting:", err);
            }
        });
    }, 60000); // 60 detik sekali
</script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


@include('backoffice.meet.modal.tambah')

@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        // Initialize DataTable
        $('#example1').DataTable({
            "responsive": true,
            "autoWidth": false,
        });
    });
</script>
@endpush
