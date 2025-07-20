@extends('backoffice.layout.main')

@section('content')

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Data penilaian</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item active">Data penilaian</li>
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
                    <h3 class="card-title">penilaian</h3>

                    <div class="card-tools">

                        <button type="button" class="btn btn-tool btn-sm" data-card-widget="collapse"
                            data-toggle="tooltip" title="Collapse">
                            <i class="fas fa-minus"></i></button>
                    </div>

                </div>
                <div class="card-body">

                    @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" penilaian="alert">
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
                                <th>Kompetensi Teknis</th>
                                <th>Kedisiplinan</th>
                                <th>Sikap</th>
                                <th>Produktivitas</th>
                                <th>Kreativitas</th>
                                <th>Kerja Sama Tim</th>
                                <th>Komunikasi</th>
                                <th>Nilai Akhir</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach($users as $key => $user)
                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td>{{ $user->name }}</td>
                                <td>
                                    <form action="/backoffice/penilaian/{{ $user->id }}/nilai" method="POST" enctype="multipart/form-data">
                                        @method('PUT')
                                        @csrf
                                    <select name="kompetensi_teknis" class="form-control"
                                        oninput="this.setCustomValidity('')" required
                                        oninvalid="this.setCustomValidity('Nilai kompetensi teknis harus diisi')">
                                        <option value="">Pilih Nilai</option>
                                        <option value="5" {{ $user->kompetensi_teknis == 5 ? 'selected' : '' }}>
                                            5</option>
                                        <option value="4" {{ $user->kompetensi_teknis == 4 ? 'selected' : '' }}>
                                            4</option>
                                        <option value="3" {{ $user->kompetensi_teknis == 3 ? 'selected' : '' }}>
                                            3</option>
                                        <option value="2" {{ $user->kompetensi_teknis == 2 ? 'selected' : '' }}>
                                            2</option>
                                        <option value="1" {{ $user->kompetensi_teknis == 1 ? 'selected' : '' }}>
                                            1</option>
                                    </select>
                                    {{-- <b>Rubrik: {{ ($user->kompetensi_teknis / 5) * (30 / 100) }}</b> --}}
                                </td>
                                <td>
                                    <select name="kedisiplinan" class="form-control"
                                        oninput="this.setCustomValidity('')" required
                                        oninvalid="this.setCustomValidity('Nilai kedisiplinan harus diisi')">
                                        <option value="">Pilih Nilai</option>
                                        <option value="5" {{ $user->kedisiplinan == 5 ? 'selected' : '' }}>
                                            5</option>
                                        <option value="4" {{ $user->kedisiplinan == 4 ? 'selected' : '' }}>
                                            4</option>
                                        <option value="3" {{ $user->kedisiplinan == 3 ? 'selected' : '' }}>
                                            3</option>
                                        <option value="2" {{ $user->kedisiplinan == 2 ? 'selected' : '' }}>
                                            2</option>
                                        <option value="1" {{ $user->kedisiplinan == 1 ? 'selected' : '' }}>
                                            1</option>
                                    </select>
                                    {{-- <b>Rubrik: {{ ($user->kedisiplinan / 5) * (30 / 100) }}</b> --}}
                                </td>
                                <td>
                                    <select name="sikap" class="form-control" oninput="this.setCustomValidity('')"
                                        required oninvalid="this.setCustomValidity('Nilai sikap harus diisi')">
                                        <option value="">Pilih Nilai</option>
                                        <option value="5" {{ $user->sikap == 5 ? 'selected' : '' }}>
                                            5</option>
                                        <option value="4" {{ $user->sikap == 4 ? 'selected' : '' }}>
                                            4</option>
                                        <option value="3" {{ $user->sikap == 3 ? 'selected' : '' }}>
                                            3</option>
                                        <option value="2" {{ $user->sikap == 2 ? 'selected' : '' }}>
                                            2</option>
                                        <option value="1" {{ $user->sikap == 1 ? 'selected' : '' }}>
                                            1</option>
                                    </select>
                                    {{-- <b>Rubrik: {{ ($user->sikap / 5) * (30 / 100) }}</b> --}}
                                </td>
                                <td>
                                    <select name="produktivitas" class="form-control"
                                        oninput="this.setCustomValidity('')" required
                                        oninvalid="this.setCustomValidity('Nilai produktivitas harus diisi')">
                                        <option value="">Pilih Nilai</option>
                                        <option value="5" {{ $user->produktivitas == 5 ? 'selected' : '' }}>
                                            5</option>
                                        <option value="4" {{ $user->produktivitas == 4 ? 'selected' : '' }}>
                                            4</option>
                                        <option value="3" {{ $user->produktivitas == 3 ? 'selected' : '' }}>
                                            3</option>
                                        <option value="2" {{ $user->produktivitas == 2 ? 'selected' : '' }}>
                                            2</option>
                                        <option value="1" {{ $user->produktivitas == 1 ? 'selected' : '' }}>
                                            1</option>
                                    </select>
                                    {{-- <b>Rubrik: {{ ($user->produktivitas / 5) * (30 / 100) }}</b> --}}
                                </td>
                                <td>
                                    <select name="kreativitas" class="form-control" oninput="this.setCustomValidity('')"
                                        required oninvalid="this.setCustomValidity('Nilai kreativitas harus diisi')">
                                        <option value="">Pilih Nilai</option>
                                        <option value="5" {{ $user->kreativitas == 5 ? 'selected' : '' }}>
                                            5</option>
                                        <option value="4" {{ $user->kreativitas == 4 ? 'selected' : '' }}>
                                            4</option>
                                        <option value="3" {{ $user->kreativitas == 3 ? 'selected' : '' }}>
                                            3</option>
                                        <option value="2" {{ $user->kreativitas == 2 ? 'selected' : '' }}>
                                            2</option>
                                        <option value="1" {{ $user->kreativitas == 1 ? 'selected' : '' }}>
                                            1</option>
                                    </select>
                                    {{-- <b>Rubrik: {{ ($user->kreativitas / 5) * (30 / 100) }}</b> --}}
                                </td>
                                <td>
                                    <select name="kerjasama" class="form-control" oninput="this.setCustomValidity('')"
                                        required oninvalid="this.setCustomValidity('Nilai kerjasama harus diisi')">
                                        <option value="">Pilih Nilai</option>
                                        <option value="5" {{ $user->kerjasama == 5 ? 'selected' : '' }}>
                                            5</option>
                                        <option value="4" {{ $user->kerjasama == 4 ? 'selected' : '' }}>
                                            4</option>
                                        <option value="3" {{ $user->kerjasama == 3 ? 'selected' : '' }}>
                                            3</option>
                                        <option value="2" {{ $user->kerjasama == 2 ? 'selected' : '' }}>
                                            2</option>
                                        <option value="1" {{ $user->kerjasama == 1 ? 'selected' : '' }}>
                                            1</option>
                                    </select>
                                    {{-- <b>Rubrik: {{ ($user->kerjasama / 5) * (30 / 100) }}</b> --}}
                                </td>
                                <td>
                                    <select name="komunikasi" class="form-control" oninput="this.setCustomValidity('')"
                                        required oninvalid="this.setCustomValidity('Nilai komunikasi harus diisi')">
                                        <option value="">Pilih Nilai</option>
                                        <option value="5" {{ $user->komunikasi == 5 ? 'selected' : '' }}>
                                            5</option>
                                        <option value="4" {{ $user->komunikasi == 4 ? 'selected' : '' }}>
                                            4</option>
                                        <option value="3" {{ $user->komunikasi == 3 ? 'selected' : '' }}>
                                            3</option>
                                        <option value="2" {{ $user->komunikasi == 2 ? 'selected' : '' }}>
                                            2</option>
                                        <option value="1" {{ $user->komunikasi == 1 ? 'selected' : '' }}>
                                            1</option>
                                    </select>
                                    {{-- <b>Rubrik: {{ ($user->komunikasi / 5) * (30 / 100) }}</b> --}}
                                </td>
                                <td>
                                    @if ($user->nilai_akhir)
                                    <input type="text" readonly value="{{ $user->kompetensi_teknis + 
                                                                            $user->kedisiplinan + 
                                                                            $user->sikap + 
                                                                            $user->produktivitas + 
                                                                            $user->kreativitas + 
                                                                            $user->kerjasama + 
                                                                            $user->komunikasi }}"
                                        class="form-control text-center">
                                    {{-- <b>Rubrik: {{ number_format($user->nilai_akhir) }}</b> --}}
                                    @else
                                    <b>0</b>
                                    @endif
                                </td>
                                <td>
                                    <button type="submit" class="btn btn-success btn-sm">
                                        <i class="fa fa-edit"></i> Nilai
                                    </button>
                                    </form>
                                    {{-- <button class="btn btn-warning btn-sm" data-toggle="modal"
                                        data-target="#edit-{{ $user->id }}" title="Nilai">
                                        <i class="fa fa-edit"></i> Nilai
                                    </button> --}}
                                    {{-- <button class="btn btn-warning btn-sm" data-toggle="modal"
                                        data-target="#edit-{{ $user->id }}" title="Ubah">
                                        <i class="fa fa-edit"></i> Ubah
                                    </button> --}}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    {{-- modal --}}
                    @foreach ($users as $user)
                    @include('backoffice.penilaian.modal.edit')
                    @include('backoffice.penilaian.modal.nilai')
                    @endforeach

                </div>

            </div>

        </div>
    </div>

</section>

@endsection
