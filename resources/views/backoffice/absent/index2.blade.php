@extends('backoffice.layout.main')

@section('content')

<section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Absensi</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item active">Absensi</li>
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

                    <div class="row flex justify-content-between mt-2">
                        <form action="" class="form-inline">
                            <div class="pr-4" style="border-right: 3px solid #0d6efd">
                                <h3 class="card-title">
                                    <b>Absensi</b>
                                </h3>
                            </div>

                            <div class="pl-4">

                            </div>
                            <div class="input-group input-group-sm mr-2">
                                <label for="">Tanggal mulai: </label>
                                <input type="date" class="form-control" name="start" placeholder="Tanggal mulai" required
                                oninvalid="this.setCustomValidity('Tanggal mulai harus diisi')" oninput="this.setCustomValidity('')"
                                value="{{ $start }}">
                            </div>
                            <div class="input-group input-group-sm">
                                <label for="">Tanggal selesai: </label>
                                <input type="date" class="form-control" name="end" placeholder="Tanggal selesai" value="{{ $end }}">
                            </div>
                            
                            <div class="input-group ml-2">
                                <button type="submit" class="btn btn-success btn-sm">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>

                            @if ($start)
                                <div class="input-group ml-2">
                                    <a href="/backoffice/absent" class="btn btn-primary btn-sm">
                                        <i class="fas fa-sync-alt"></i>
                                    </a>
                                </div>
                            @endif

                        </form>
    
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool btn-sm" data-card-widget="collapse"
                                data-toggle="tooltip" title="Collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>

                    {{-- <h3 class="card-title">Absensi</h3>

                    <div class="card-tools">
                        <button type="button" class="btn btn-tool btn-sm" data-card-widget="collapse"
                            data-toggle="tooltip" title="Collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div> --}}

                </div>
                <div class="card-body">

                    @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" absent="alert">
                        <strong>Berhasil </strong>{{ session('success') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    @endif

                    @if ($start)
                        <div class="search">
                            <div class="text-center">
                                <span class="fa fa-search"></span> Hasil Pencarian dari: <b>
                                    @if ($start)
                                    {{  \Carbon\Carbon::parse($start)->locale('id')->isoFormat('dddd, D MMMM YYYY') }}
                                    @endif
                                    @if ($end)
                                    Sampai {{  \Carbon\Carbon::parse($end)->locale('id')->isoFormat('dddd, D MMMM YYYY') }}
                                    @endif
                                </b>
                            </div>
                            <hr>
                        </div>
                    @endif

                    <table class="table table-bordered table-hover text-center" id="example1">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Karyawan</th>
                                <th>Tanggal</th>
                                <th>Shift</th>
                                <th>Jam Masuk</th>
                                <th>Jam Pulang</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach($absents as $key => $absent)
                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td>
                                    @if ($absent->user_id == null)
                                        <h5>
                                            <span class="badge badge-danger"> <i class="fa fa-times"></i> Karyawan Resign</span>
                                        </h5>
                                    @else
                                        @if (auth()->user()->role_id == 1)
                                            <button class="badge badge-light" data-toggle="modal" data-target="#detail-{{ $absent->user->id }}" title="Detail User">
                                                <i class="fa fa-eye"></i> {{ $absent->user->name }}
                                            </button>
                                        @endif
                                    @endif
                                </td>
                                <td>
                                    {{  \Carbon\Carbon::parse($absent->date)->locale('id')->isoFormat('dddd, D MMMM YYYY') }}
                                </td>
                                <td>
                                    @if ($absent->shift_id)
                                        {{ $absent->shift->name }}
                                    @endif
                                </td>
                                <td>{{ $absent->start }}</td>
                                <td>{{ $absent->end }}</td>
                                <td>{{ $absent->status }}</td>
                                <td>
                                    <a href="/backoffice/absent/{{ $absent->id }}/detail" class="btn btn-sm btn-primary">
                                        <i class="fa fa-eye"></i> Detail
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    {{-- modal --}}
                    @foreach ($absents as $absent)
                        @if ($absent->user_id != null)
                            @include('backoffice.absent.modal.delete')
                            @include('backoffice.absent.modal.user')
                            @include('backoffice.absent.modal.description-user')
                        @endif
                    @endforeach

                </div>

            </div>

        </div>
    </div>

</section>

@endsection