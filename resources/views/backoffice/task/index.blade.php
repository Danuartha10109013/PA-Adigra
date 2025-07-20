@extends('backoffice.layout.main')

@section('content')
    
<section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Data Task / Tugas</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item active">Data Task / Tugas</li>
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

                    <div class="row flex justify-content-between mt-2">
                        <form action="" class="form-inline">
                            <div class="pr-4" style="border-right: 3px solid #0d6efd">
                                <h3 class="card-title">
                                    <b>Task / Tugas</b>
                                </h3>
                            </div>

                            <div class="pl-4">

                            </div>
                            <div class="input-group input-group-sm">
                                <label for="">Cari: </label>
                                <select name="bulan" class="form-control ml-2" required
                                    oninput="this.setCustomValidity('')" oninvalid="this.setCustomValidity('Bulan harus dipilih')">
                                    <option value="">-- Pilih Bulan --</option>
                                    <option value="01" @if ($bulan == '01') selected @endif>Januari</option>
                                    <option value="02" @if ($bulan == '02') selected @endif>Februari</option>
                                    <option value="03" @if ($bulan == '03') selected @endif>Maret</option>
                                    <option value="04" @if ($bulan == '04') selected @endif>April</option>
                                    <option value="05" @if ($bulan == '05') selected @endif>Mei</option>
                                    <option value="06" @if ($bulan == '06') selected @endif>Juni</option>
                                    <option value="07" @if ($bulan == '07') selected @endif>Juli</option>
                                    <option value="08" @if ($bulan == '08') selected @endif>Agustus</option>
                                    <option value="09" @if ($bulan == '09') selected @endif>September</option>
                                    <option value="10" @if ($bulan == '10') selected @endif>Oktober</option>
                                    <option value="11" @if ($bulan == '11') selected @endif>November</option>
                                    <option value="12" @if ($bulan == '12') selected @endif>Desember</option>
                                </select>
                            </div>

                            <div class="input-group input-group-sm">
                                <select name="tahun" class="form-control ml-2" required
                                    oninput="this.setCustomValidity('')" oninvalid="this.setCustomValidity('Tahun harus dipilih')">
                                    <option value="">-- Pilih Tahun --</option>
                                    @for ($i = 2024; $i <= date('Y'); $i++)
                                        <option value="{{ $i }}" @if ($tahun == $i) selected @endif>{{ $i }}</option>
                                    @endfor
                                </select>
                            </div>
                            
                            <div class="input-group ml-2">
                                <button type="submit" class="btn btn-success btn-sm">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>

                            @if ($bulan)
                                <div class="input-group ml-2">
                                    <a href="/backoffice/task" class="btn btn-primary btn-sm">
                                        <i class="fas fa-sync-alt"></i>
                                    </a>
                                </div>
                            @endif

                        </form>
    
                        <div class="card-tools">
                            @if (auth()->user()->role_id != 1)
                                <button title="Tambah" type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#tambah">
                                    <span class="fa fa-plus"></span> Tambah
                                </button>
                                @include('backoffice.task.modal.add')
                            @endif
    
                            <button type="button" class="btn btn-tool btn-sm" data-card-widget="collapse"
                                data-toggle="tooltip" title="Collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>

                </div>
                <div class="card-body">

                    @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" task="alert">
                        <strong>Berhasil </strong>{{ session('success') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    @endif

                    @if ($bulan)

                        <div class="callout callout-info">
                            <div class="d-flex justify-content-between">
                                <div class="search">
                                    <div class="text-center">
                                        <span class="fa fa-search"></span> Hasil Pencarian dari: <b>
                                            @if ($bulan)
                                                @if ($bulan == '01')
                                                    Januari
                                                @elseif ($bulan == '02')
                                                    Februari
                                                @elseif ($bulan == '03')
                                                    Maret
                                                @elseif ($bulan == '04')
                                                    April
                                                @elseif ($bulan == '05')
                                                    Mei
                                                @elseif ($bulan == '06')
                                                    Juni
                                                @elseif ($bulan == '07')
                                                    Juli
                                                @elseif ($bulan == '08')
                                                    Agustus
                                                @elseif ($bulan == '09')
                                                    September
                                                @elseif ($bulan == '10')
                                                    Oktober
                                                @elseif ($bulan == '11')
                                                    November
                                                @elseif ($bulan == '12')
                                                    Desember
                                                @endif
                                            @endif
                                            @if ($tahun)
                                                {{ $tahun }}
                                            @endif
                                        </b>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr>

                    @endif

                    <table class="table table-bordered table-hover text-center" id="example1">
                        <thead>
                            <tr>
                                <th>#</th>
                                @if (auth()->user()->role_id == 1)
                                    <th>Karyawan</th>
                                @endif
                                <th>Dibuat Tanggal</th>
                                <th>Task / Tugas</th>
                                <th>Berkas</th>
                                @if (auth()->user()->role_id == 2)
                                    <th>Aksi</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($tasks as $task)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    @if (auth()->user()->role_id == 1)
                                        <td>
                                            <button class="badge badge-light" data-toggle="modal" data-target="#detail-{{ $task->user->id }}" title="Detail User">
                                                <i class="fa fa-eye"></i> {{ $task->user->name }}
                                            </button>
                                        </td>
                                    @endif
                                    <td>{{ $task->created_at }}</td>
                                    <td>{{ $task->task }}</td>
                                    <td>
                                        @if ($task->file)
                                            <a href="/backoffice/task/{{ $task->id }}/preview" class="badge badge-light" target="_blank">
                                                <i class="fa fa-eye"></i>
                                            </a>
                                            {{ $task->filename }} 
                                            <!-- | 
                                            <button class="badge badge-danger" data-toggle="modal" data-target="#delete-file-{{ $task->id }}" title="Hapus">
                                                <i class="fa fa-trash"></i>
                                            </button> -->
                                        @else
                                            <span class="badge badge-light">Tidak ada berkas</span>
                                        @endif
                                    </td>
                                    @if (auth()->user()->role_id == 2)
                                        <td>
                                            <button class="btn btn-sm btn-warning" data-toggle="modal" data-target="#edit-{{ $task->id }}" title="Ubah">
                                                <i class="fa fa-edit"></i> Ubah
                                            </button>
                                            <button class="btn btn-sm btn-danger" data-toggle="modal" data-target="#delete-{{ $task->id }}" title="Hapus">
                                                <i class="fa fa-trash"></i> Hapus
                                            </button>
                                        </td>
                                    @endif
                                </tr>
                            @endforeach

                        </tbody>
                    </table>

                    {{-- modal --}}
                    @foreach ($tasks as $task)
                        @if (auth()->user()->role_id == 1)
                            @include('backoffice.task.modal.user')
                        @endif
                        @include('backoffice.task.modal.edit')
                        @include('backoffice.task.modal.delete')
                    @endforeach

                </div>

            </div>

        </div>
    </div>

</section>

@endsection