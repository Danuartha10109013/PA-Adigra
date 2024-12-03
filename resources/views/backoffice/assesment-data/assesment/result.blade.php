@extends('backoffice.layout.main')

@section('content')
    
<section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Data Penilaian</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item active">Data Penilaian</li>
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
                    <h3 class="card-title">Penilaian</h3>

                    <div class="card-tools">

                        <button type="button" class="btn btn-tool btn-sm" data-card-widget="collapse"
                            data-toggle="tooltip" title="Collapse">
                            <i class="fas fa-minus"></i></button>
                    </div>

                </div>
                <div class="card-body">

                    @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" user="alert">
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
                                <th>Karyawan</th>
                                
                                {{-- foreach kriteria --}}
                                @foreach ($kriteria as $key => $k)
                                    <td>{{ $k['name'] }}</td>
                                @endforeach
                                {{-- end foreach kriteria --}}

                                <th>Nilai</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach($hasil as $key => $h)
                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td>{{ $h['user']['name'] }}</td>

                                {{-- @foreach ($h['normalisasi'] as $key => $n) --}}
                                @foreach ($h['normalisasi'] as $key => $n)
                                    <td>
                                        {{ $n }}<br>
                                    </td>
                                @endforeach
                                {{-- @endforeach --}}

                                <td>{{ $h['total'] }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>

            </div>

        </div>
    </div>

</section>

@endsection