@extends('backoffice.layout.main')

@section('content')

<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Absensi hari ini</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item active">Absensi hari ini</li>
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
            <form action="/backoffice/dashboard" class="form-inline">
              <div class="pr-4" style="border-right: 3px solid #0d6efd">
                <h3 class="card-title">
                  <b>Absensi</b>
                </h3>
              </div>

              <div class="pl-4">

              </div>
              <div class="input-group input-group-sm">
                <label for="">Kategori: </label>
                <select name="category" class="form-control ml-2">
                  <option value="">Hadir</option>
                  <option value="cuti" {{ $category=='cuti' ? 'selected' : '' }}>Cuti</option>
                  <option value="izin" {{ $category=='izin' ? 'selected' : '' }}>Izin</option>
                  <option value="sakit" {{ $category=='sakit' ? 'selected' : '' }}>Sakit</option>
                  <option value="belum-hadir" {{ $category=='belum-hadir' ? 'selected' : '' }}>Belum Hadir</option>
                </select>
              </div>
              <div class="input-group ml-2">
                <button type="submit" class="btn btn-success btn-sm">
                  <i class="fas fa-search"></i>
                </button>
              </div>

              @if ($category)
              <div class="input-group ml-2">
                <a href="/backoffice/dashboard" class="btn btn-primary btn-sm">
                  <i class="fas fa-sync-alt"></i>
                </a>
              </div>
              @endif

            </form>
            
            <div class="card-tools">
              <button type="button" class="btn btn-tool btn-sm" data-card-widget="collapse" data-toggle="tooltip"
                title="Collapse">
                <i class="fas fa-minus"></i>
              </button>
            </div>
          </div>

        </div>
        <div class="card-body">

          @if(session('success'))
          <div class="alert alert-success alert-dismissible fade show" absen="alert">
            <strong>Berhasil </strong>{{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          @endif

          <div class="row">
            <div class="col-md-3">
              <div class="card bg-success">
                <div class="card-body">
                  <h3>Hadir: <b>{{ $countAbsenToday }}</b> </h3>
                </div>
              </div>
            </div>
            <div class="col-md-3">
              <div class="card bg-danger">
                <div class="card-body">
                  <h3>Belum Hadir: <b>{{ $countUserNoAbsen }}</b> </h3>
                </div>
              </div>
            </div>
            <div class="col-md-2">
              <div class="card bg-primary">
                <div class="card-body">
                  <h3>Cuti: <b>{{ $countCutiToday }}</b></h3>
                </div>
              </div>
            </div>
            <div class="col-md-2">
              <div class="card bg-primary">
                <div class="card-body">
                  <h3>Izin: <b>{{ $countIzinToday }}</b></h3>
                </div>
              </div>
            </div>
            <div class="col-md-2">
              <div class="card bg-primary">
                <div class="card-body">
                  <h3>Sakit: <b>{{ $countSakitToday }}</b></h3>
                </div>
              </div>
            </div>
          </div>

          <hr>

          <div class="row">
            <div class="col-md-12">
              <div class="d-flex justify-content-around">
                <div>
                  @if ($category)
                    <div class="search">
                      <div class="text-center">
                        <h3>---
                          <span class="fa fa-search"></span> Kategori Absen:
                          @if ($category == 'cuti')
                          <b>Cuti</b>
                          @elseif ($category == 'izin')
                          <b>Izin</b>
                          @elseif ($category == 'sakit')
                          <b>Sakit</b>
                          @elseif ($category == 'belum-hadir')
                          <b>Belum Hadir</b>
                          @endif
                        ---</h3>
                      </div>
                    </div>
                  @elseif ($category == null)
                    <div class="search">
                      <div class="text-center">
                        <h3>---
                          <span class="fa fa-search"></span> Kategori Absen: <b>Hadir</b>
                        ---</h3>
                      </div>
                    </div>
                  @endif
                </div>
                <div>
                  <h2>--
                    <span class="fa fa-calendar-alt"></span> {{ \Carbon\Carbon::parse(now())->locale('id')->isoFormat('dddd, D MMMM YYYY') }} 
                  --</h2>
                </div>
              </div>
            </div>
          </div>

          <hr>

          <table class="table table-bordered table-hover text-center" id="example1">
            <thead>
              <tr>
                <th>#</th>
                <th>Karyawan</th>
                @if ($category != 'belum-hadir')
                  @if ($category == null)
                    <th>Jam Masuk</th>
                    <th>Jam Pulang</th>
                    <th>Shift</th>
                  @endif
                  <th>Kantor</th>
                @endif
                  <th>Status</th>
                  <th>Keterangan</th>
              </tr>
            </thead>
            <tbody>
              @foreach($absens as $key => $absen)
              <tr>
                <td>{{ $key+1 }}</td>
                @if ($category == 'belum-hadir')
                  <td>
                    <button class="badge badge-light" data-toggle="modal" data-target="#detail-{{ $absen->id }}"
                      title="Detail User">
                      <i class="fa fa-eye"></i> {{ $absen->name }}
                    </button>
                  </td>
                @else
                  <td>
                    @if ($absen->user_id == null)
                      <h5>
                        <span class="badge badge-danger">Karyawan resign</span>
                      </h5>
                    @else
                      <button class="badge badge-light" data-toggle="modal" data-target="#detail-{{ $absen->user->id }}"
                        title="Detail User">
                        <i class="fa fa-eye"></i> {{ $absen->user->name }}
                      </button>
                    @endif
                  </td>
                  @if ($category == null)
                    <td>{{ $absen->start }}</td>
                    <td>{{ $absen->end }}</td>
                    <td>
                      @if ($absen->shift_id == null)
                        -
                      @else
                        {{ $absen->shift->name }}
                      @endif
                    </td>
                  @endif
                  <td>{{ $absen->office->name }}</td>
                @endif
                <td>{{ $absen->status }}</td>
                <td>{{ $absen->description }}</td>
              @endforeach
            </tbody>
          </table>

          {{-- modal --}}
          @foreach($absens as $absen)
            @if ($absen->user_id != null)
              @if ($category == 'belum-hadir')
                @include('backoffice.dashboard.modal.user-no-absen')
              @else
                @include('backoffice.dashboard.modal.user')
              @endif
            @endif
          @endforeach

        </div>

      </div>

    </div>
  </div>

</section>

@endsection