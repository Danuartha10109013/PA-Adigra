@extends('backoffice.layout.main')

@section('content')
    
<section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Data Cuti</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item active">Data Cuti</li>
          </ol>
        </div>
      </div>
    </div>
</section>

<section class="content">

    <div class="row justify-content-center">
        <div class="col-md-12">

            <!-- Default box -->
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <h3 class="card-title">Cuti</h3>

                    <div class="card-tools">
                        {{-- <a href="/backoffice/submission/tambah" class="btn btn-success btn-sm" title="Tambah">
                            <i class="fas fa-plus"></i> Tambah
                        </a> --}}
                        <button title="Tambah" type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#tambah">
                            <span class="fa fa-plus"></span> Ajukan Cuti
                        </button>

                        {{-- @if ($errors->any())
                            <script>
                                jQuery(function() {
                                    $('#tambah').modal('show');
                                });
                            </script>
                        @endif --}}

                        {{-- Modal --}}
                        @include('backoffice.submission.cuti.modal.add')

                        <button type="button" class="btn btn-tool btn-sm" data-card-widget="collapse"
                            data-toggle="tooltip" title="Collapse">
                            <i class="fas fa-minus"></i></button>
                    </div>

                </div>
                <div class="card-body">

                    @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" submission="alert">
                        <strong>Berhasil </strong>{{ session('success') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    @endif

                    <table class="table table-bordered table-hover text-center" id="example1">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Mulai Cuti</th>
                                <th>Selesai Cuti</th>
                                <th>Jumlah Hari</th>
                                <th>Alasan</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach($submissions as $key => $submission)
                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td>{{ $submission->start_date }}</td>
                                <td>{{ $submission->end_date }}</td>
                                <td>{{ $submission->total_day }}</td>
                                <td>{{ $submission->description }}</td>
                                <td>
                                    @if ($submission->status == "Pengajuan")
                                        <h5>
                                            <span class="badge badge-warning">Pengajuan</span>
                                        </h5>
                                    @elseif ($submission->status == "Disetujui")
                                        <h5>
                                            <span class="badge badge-success">Disetujui</span>
                                        </h5>
                                    @elseif ($submission->status == "Ditolak")
                                        <h5>
                                            <span class="badge badge-danger">Ditolak</span> 
                                        </h5>
                                    @endif
                                </td>
                                <td>
                                    <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#edit-{{ $submission->id }}" title="Ubah">
                                        <i class="fa fa-edit"></i> Ubah
                                    </button>
                                    <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#delete-{{ $submission->id }}" title="Hapus">
                                        <i class="fa fa-trash"></i> Hapus
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    {{-- modal --}}
                    @foreach ($submissions as $submission)
                        @include('backoffice.submission.cuti.modal.edit')
                        @include('backoffice.submission.cuti.modal.delete')
                    @endforeach

                </div>

            </div>

        </div>
    </div>

</section>

@endsection