@extends('backoffice.layout.main')

@section('content')
    
<section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Data Izin / Sakit</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item active">Data Izin / Sakit</li>
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
                                    <b>Izin / Sakit</b>
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
                                    <a href="/backoffice/absent" class="btn btn-primary btn-sm">
                                        <i class="fas fa-sync-alt"></i>
                                    </a>
                                </div>
                            @endif

                        </form>
    
                        <div class="card-tools">
                            @if (auth()->user()->role_id != 1)
                                <button title="Tambah" type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#tambah">
                                    <span class="fa fa-plus"></span> Ajukan Izin / Sakit
                                </button>
    
                                @include('backoffice.submission.izin-sakit.modal.add')
                            @endif
                            <button type="button" class="btn btn-tool btn-sm" data-card-widget="collapse"
                                data-toggle="tooltip" title="Collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>

                    {{-- <h3 class="card-title">Izin / Sakit</h3>

                    <div class="card-tools">
                        @if (auth()->user()->role_id != 1)
                            <button title="Tambah" type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#tambah">
                                <span class="fa fa-plus"></span> Ajukan Izin / Sakit
                            </button>

                            @include('backoffice.submission.izin-sakit.modal.add')
                        @endif
                        <button type="button" class="btn btn-tool btn-sm" data-card-widget="collapse"
                            data-toggle="tooltip" title="Collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div> --}}

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
                                <div class="">
                                    <h5>
                                        Izin: <b>{{ $izin }} Orang</b> |
                                        Sakit: <b>{{ $sakit }} Orang</b> 
                                    </h5>
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
                                <th>Mulai Pengajuan</th>
                                <th>Selesai Pengajuan</th>
                                <th>Jumlah Hari</th>
                                <th>Tipe</th>
                                <th>Alasan</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach($submissions as $key => $submission)
                            <tr>
                                <td>{{ $key+1 }}</td>
                                @if (auth()->user()->role_id == 1)
                                <td>
                                    @if ($submission->user_id == null)
                                        <h5>
                                            <span class="badge badge-danger"> <i class="fa fa-times"></i> Karyawan Resign</span>
                                        </h5>
                                    @else
                                        @if (auth()->user()->role_id == 1)
                                            <button class="badge badge-light" data-toggle="modal" data-target="#detail-{{ $submission->user->id }}" title="Detail User">
                                                <i class="fa fa-eye"></i> {{ $submission->user->name }}
                                            </button>
                                        @endif
                                    @endif
                                </td>
                                @endif
                                <td>{{ $submission->created_at }}</td>
                                <td>{{  \Carbon\Carbon::parse($submission->start_date)->locale('id')->isoFormat('dddd, D MMMM YYYY') }}</td>
                                <td>{{  \Carbon\Carbon::parse($submission->end_date)->locale('id')->isoFormat('dddd, D MMMM YYYY') }}</td>
                                <td>{{ $submission->total_day }}</td>
                                <td>{{ $submission->type }}</td>
                                <td>
                                    <button class="badge badge-light" data-toggle="modal" data-target="#description-{{ $submission->id }}" title="Alasan">
                                        <i class="fa fa-eye"></i> Lihat alasan
                                    </button>
                                </td>
                                <td>
                                    @if ($submission->status == "Pengajuan")
                                        <div class="d-flex justify-content-center">
                                            <h5 class="mr-1">
                                                <span class="badge badge-warning"> <i class="fa fa-clock"></i> Pengajuan</span>
                                            </h5>
                                            @if ($submission->status_description)
                                                | <button class="badge badge-light ml-1" data-toggle="modal" data-target="#adjust-{{ $submission->id }}" title="Penyesuaian pengajuan">
                                                    <i class="fa fa-eye"></i> Penyesuaian
                                                </button>
                                            @endif
                                        </div>
                                    @elseif ($submission->status == "Disetujui")
                                        <h5>
                                            <span class="badge badge-success"> <i class="fa fa-check"></i> Disetujui</span>
                                        </h5>
                                    @elseif ($submission->status == "Ditolak")
                                        <div class="d-flex justify-content-center">
                                            <h5>
                                                <span class="badge badge-danger"> <i class="fa fa-times"></i> Ditolak</span> | 
                                            </h5>
                                            <button class="badge badge-light ml-1" data-toggle="modal" data-target="#description-status-{{ $submission->id }}" title="Keterangan ditolak">
                                                <i class="fa fa-eye"></i> Keterangan
                                            </button>
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    @if (auth()->user()->role_id == 1)
                                        @if ($submission->status == "Pengajuan")
                                            <button class="btn btn-success btn-sm" data-toggle="modal" data-target="#accept-{{ $submission->id }}" title="Setuju">
                                                <i class="fa fa-check"></i> Setuju
                                            </button>
                                            <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#reject-{{ $submission->id }}" title="Tolak">
                                                <i class="fa fa-times"></i> Tolak
                                            </button>
                                        @endif
                                    @else
                                        @if ($submission->status != "Disetujui")
                                            <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#edit-{{ $submission->id }}" title="Ubah">
                                                <i class="fa fa-edit"></i>
                                                @if ($submission->status == "Pengajuan")
                                                    Ubah
                                                @elseif ($submission->status == "Ditolak")
                                                    Sesuaikan
                                                @endif
                                            </button>
                                            <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#delete-{{ $submission->id }}" title="Hapus">
                                                <i class="fa fa-trash"></i> Hapus
                                            </button>
                                        @endif
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    {{-- modal --}}
                    @foreach ($submissions as $submission)
                        @if ($submission->user_id != null)
                            @include('backoffice.submission.izin-sakit.modal.edit')
                            @include('backoffice.submission.izin-sakit.modal.delete')
                            @include('backoffice.submission.izin-sakit.modal.accept')
                            @include('backoffice.submission.izin-sakit.modal.reject')
                            @include('backoffice.submission.izin-sakit.modal.user')
                            @include('backoffice.submission.izin-sakit.modal.description-user')
                            @if ($submission->status_description != null)
                                @include('backoffice.submission.izin-sakit.modal.description-status')
                                @include('backoffice.submission.izin-sakit.modal.adjust')
                            @endif
                        @endif
                    @endforeach

                </div>

            </div>

        </div>
    </div>

</section>

@endsection