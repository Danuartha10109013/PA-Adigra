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

                                {{-- foreach $criterias --}}
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
                                @if ($user->assesments->count() > 0)
                                    @foreach($user->assesments as $assesment)
                                        <td>
                                            <form action="/backoffice/assesment-data/assesment/update" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="user_id" value="{{ $user->id }}">
                                                <input type="hidden" name="criteria_id" value="{{ $assesment->criteria_id }}">
                                                <select name="score[{{ $assesment->criteria_id }}]" class="form-control" required
                                                    oninvalid="this.setCustomValidity('Nilai harus diisi')" oninput="this.setCustomValidity('')">
                                                    <option value="5" @if ( $user->assesments->where('criteria_id', $assesment->criteria_id)->first()->score == 5 ) selected @endif>(5) Sangat Baik</option>
                                                    <option value="4" @if ( $user->assesments->where('criteria_id', $assesment->criteria_id)->first()->score == 4 ) selected @endif>(4) Baik</option>
                                                    <option value="3" @if ( $user->assesments->where('criteria_id', $assesment->criteria_id)->first()->score == 3 ) selected @endif>(3) Cukup</option>
                                                    <option value="2" @if ( $user->assesments->where('criteria_id', $assesment->criteria_id)->first()->score == 2 ) selected @endif>(2) Kurang</option>
                                                    <option value="1" @if ( $user->assesments->where('criteria_id', $assesment->criteria_id)->first()->score == 1 ) selected @endif>(1) Sangat Kurang</option>
                                                </select>
                                        </td>
                                    @endforeach
                                    <td>
                                        <button type="submit" class="btn btn-success btn-sm" title="Simpan">
                                            <i class="fa fa-edit"></i> Simpan
                                        </button>
                                    </td>
                                    </form>
                                @elseif ($user->assesments)
                                    @foreach($criterias as $criteria)
                                        <td>
                                            <form action="/backoffice/assesment-data/assesment/tes" method="POST">
                                                @csrf
                                                <input type="hidden" name="user_id" value="{{ $user->id }}">
                                                <input type="hidden" name="criteria_id" value="{{ $criteria->id }}">
                                                <select name="score[]" class="form-control" required
                                                    oninvalid="this.setCustomValidity('Nilai harus diisi')" oninput="this.setCustomValidity('')">
                                                    <option value="">-- Pilih Nilai --</option>
                                                    <option value="5">(5) Sangat Baik</option>
                                                    <option value="4">(4) Baik</option>
                                                    <option value="3">(3) Cukup</option>
                                                    <option value="2">(2) Kurang</option>
                                                    <option value="1">(1) Sangat Kurang</option>
                                                    @if($user->assesments)
                                                    @endif
                                                </select>
                                        </td>
                                    @endforeach
                                    <td>
                                        <button type="submit" class="btn btn-success btn-sm" title="Simpan">
                                            <i class="fa fa-edit"></i> Simpan
                                        </button>
                                    </td>
                                    </form>
                                @endif



                                {{-- @foreach($criterias as $criteria)
                                    <td>
                                        <form action="/backoffice/assesment-data/assesment/tes" method="POST">
                                            @csrf
                                            <input type="hidden" name="user_id" value="{{ $user->id }}">
                                            <input type="hidden" name="criteria_id" value="{{ $criteria->id }}">
                                            <select name="score[]" class="form-control" required
                                                oninvalid="this.setCustomValidity('Nilai harus diisi')" oninput="this.setCustomValidity('')">
                                                <option value="">-- Pilih Nilai --</option>
                                                <option value="5">(5) Sangat Baik</option>
                                                <option value="4">(4) Baik</option>
                                                <option value="3">(3) Cukup</option>
                                                <option value="2">(2) Kurang</option>
                                                <option value="1">(1) Sangat Kurang</option>
                                                @if($user->assesments)
                                                @endif
                                            </select>
                                    </td>
                                @endforeach --}}

                                {{-- <td>
                                    <button type="submit" class="btn btn-success btn-sm" title="Simpan">
                                        <i class="fa fa-edit"></i> Simpan
                                    </button>
                                </td> --}}
                                {{-- </form> --}}
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