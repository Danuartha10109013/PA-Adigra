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
                            <i class="fas fa-minus"></i>
                        </button>
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
                    
                                {{-- Loop Kriteria --}}
                                @foreach($criterias as $criteria)
                                    <th>{{ $criteria->name }}</th>
                                @endforeach
                    
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $key => $user)
                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td>{{ $user->name }}</td>
                                <form action="/backoffice/assesment-data/assesment/update" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="user_id" value="{{ $user->id }}">
                    
                                    @foreach($criterias as $criteria)
                                        <td>
                                            <select name="score[{{ $criteria->id }}]" class="form-control" required>
                                                <option value="">-- Pilih Nilai --</option>
                                                @for($i = 5; $i >= 1; $i--)
                                                    <option value="{{ $i }}" @if(optional($user->assesments->where('criteria_id', $criteria->id)->first())->score == $i) selected @endif>
                                                        ({{ $i }}) {{ ['Sangat Kurang', 'Kurang', 'Cukup', 'Baik', 'Sangat Baik'][$i - 1] }}
                                                    </option>
                                                @endfor
                                            </select>
                                        </td>
                                    @endforeach
                    
                                    <td>
                                        <button type="submit" class="btn btn-success btn-sm" title="Simpan">
                                            <i class="fa fa-save"></i> Simpan
                                        </button>
                                    </td>
                                </form>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    {{-- modal --}}
                    {{-- @foreach ($users as $user)
                        @include('backoffice.user-data.user.modal.edit')
                        @include('backoffice.user-data.user.modal.delete')
                    @endforeach --}}

                </div>

            </div>

        </div>
    </div>

</section>

@endsection