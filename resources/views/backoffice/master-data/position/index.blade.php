@extends('backoffice.layout.main')

@section('content')
    
<section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Data Jabatan</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item active">Data Jabatan</li>
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
                    <h3 class="card-title">Jabatan</h3>

                    <div class="card-tools">
                        {{-- <a href="/backoffice/position/tambah" class="btn btn-success btn-sm" title="Tambah">
                            <i class="fas fa-plus"></i> Tambah
                        </a> --}}
                        <button title="Tambah" type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#tambah">
                            <span class="fa fa-plus"></span> Tambah
                        </button>

                        {{-- @if ($errors->any())
                            <script>
                                jQuery(function() {
                                    $('#tambah').modal('show');
                                });
                            </script>
                        @endif --}}

                        {{-- Modal --}}
                        @include('backoffice.master-data.position.modal.add')

                        <button type="button" class="btn btn-tool btn-sm" data-card-widget="collapse"
                            data-toggle="tooltip" title="Collapse">
                            <i class="fas fa-minus"></i></button>
                    </div>

                </div>
                <div class="card-body">

                    @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" position="alert">
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
                                <th>Jabatan</th>
                                {{-- <th>Pengguna</th> --}}
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach($positions as $key => $position)
                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td>{{ $position->name }}</td>
                                {{-- <td>{{ $position->users->count() }} Orang</td> --}}
                                <td>
                                    <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#edit-{{ $position->id }}" title="Ubah">
                                        <i class="fa fa-edit"></i> Ubah
                                    </button>
                                    <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#delete-{{ $position->id }}" title="Hapus">
                                        <i class="fa fa-trash"></i> Hapus
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    {{-- modal --}}
                    @foreach ($positions as $position)
                        @include('backoffice.master-data.position.modal.edit')
                        @include('backoffice.master-data.position.modal.delete')
                    @endforeach

                </div>

            </div>

        </div>
    </div>

</section>

@endsection