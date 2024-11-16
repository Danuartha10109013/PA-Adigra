@extends('backoffice.layout.main')

@section('content')

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Profil</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="/backoffice/dashboard">Beranda</a></li>
                    <li class="breadcrumb-item active">Profil</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<section class="content">

    <div class="row justify-content-center">

        <div class="col-md-5">

            <div class="card">
                <div class="card-header bg-primary">
                    <h3 class="card-title">Data</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-primary btn-sm" data-card-widget="collapse"
                            data-toggle="tooltip" title="Collapse">
                            <i class="fas fa-minus"></i></button>
                    </div>
                </div>
                <div class="card-body">
                    <div class=" text-center">
                        <label for="foto">Foto </label>
                        @if ($user->foto_profil)
                        <img src="{{ asset('storage/user/'.$user->foto_profil) }}"
                            class=" img-fluid d-block rounded" alt=""
                            style="width: 150px; height: 150px; margin-left: auto; margin-right: auto">
                        @else
                        <img src="{{ asset('images/profile.png') }}" class="gambarPreviewuser img-fluid mb-3 d-block"
                            alt="" style="width: 150px; height: 150px; margin-left: auto; margin-right: auto">
                        @endif
                    </div>
                    <hr>
                    <div class=" d-flex justify-content-between pl-4 pr-4">
                        <p>
                            <b>Nama:</b>
                        </p>
                        <p>
                            {{ $user->nama }}
                        </p>
                    </div>
                    <div class=" d-flex justify-content-between pl-4 pr-4">
                        <p>
                            <b>Email:</b>
                        </p>
                        <p>
                            {{ $user->email }}
                        </p>
                    </div>
                    <div class=" d-flex justify-content-between pl-4 pr-4">
                        <p>
                            <b>Jenis kelamin:</b>
                        </p>
                        <p>
                            @if ($user->jenis_kelamin == null)
                            <span class="badge badge-warning"><i class="fa fa-exclamation-triangle"></i> Belum
                                melengkapi data</span>
                            @endif
                            {{ $user->jenis_kelamin }}
                        </p>
                    </div>
                    <div class=" d-flex justify-content-between pl-4 pr-4">
                        <p>
                            <b>Agama:</b>
                        </p>
                        <p>
                            @if ($user->agama == null)
                            <span class="badge badge-warning"><i class="fa fa-exclamation-triangle"></i> Belum
                                melengkapi data</span>
                            @endif
                            {{ $user->agama }}
                        </p>
                    </div>
                    <div class=" d-flex justify-content-between pl-4 pr-4">
                        <p>
                            <b>Tempat, Tanggal Lahir:</b> 
                        </p>
                        <p>
                            @if ($user->tempat_lahir == null  && $user->tanggal_lahir == null)
                                <span class="badge badge-warning"><i class="fa fa-exclamation-triangle"></i> Belum melengkapi data</span>
                            @endif
                            {{ $user->tempat_lahir }}, {{ date('d F Y', strtotime($user->tanggal_lahir)) }}
                        </p>
                    </div>
                    <div class=" d-flex justify-content-between pl-4 pr-4">
                        <p>
                            <b>Alamat:</b>
                        </p>
                        <p>
                            @if ($user->alamat == null)
                            <span class="badge badge-warning"><i class="fa fa-exclamation-triangle"></i> Belum
                                melengkapi data</span>
                            @endif
                            {{ $user->alamat }}
                        </p>
                    </div>
                    <div class=" d-flex justify-content-between pl-4 pr-4">
                        <p>
                            <b>No. telpon:</b>
                        </p>
                        <p>
                            @if ($user->no_hp == null)
                            <span class="badge badge-warning"><i class="fa fa-exclamation-triangle"></i> Belum
                                melengkapi data</span>
                            @endif
                            {{ $user->no_hp }}
                        </p>
                    </div>
                </div>
            </div>

        </div>

        <div class="col-md-4">
            <form action="/backoffice/user-data/user/{{ auth()->user()->id }}/ubah-password" method="POST"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="card">
                    <div class="card-header bg-primary">
                        <h3 class="card-title">Form ubah password</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-primary btn-sm" data-card-widget="collapse"
                                data-toggle="tooltip" title="Collapse">
                                <i class="fas fa-minus"></i></button>
                        </div>
                    </div>
                    <div class="card-body">

                        @if(session('warning'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Gagal</strong> {{ session('warning') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        @endif

                        <div class="form-group">
                            <label for="password_lama">Password lama <span class="text-danger">*</span></label>
                            <input type="password" name="password_lama" id="password_lama"
                                class="form-control @if ( $errors->has('password_lama')) is-invalid @endif" required
                                oninput="setCustomValidity('')"
                                oninvalid="this.setCustomValidity('Password lama harus diisi')"
                                value="{{ old('password_lama') }}">
                            @if ($errors->has('password_lama'))
                            <small class="text-danger">{{ $errors->first('password_lama') }}</small>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="password_baru">Password baru <span class="text-danger">*</span></label>
                            <input type="password" name="password_baru" id="password_baru"
                                class="form-control @if ( $errors->has('password_baru')) is-invalid @endif" required
                                oninput="setCustomValidity('')"
                                oninvalid="this.setCustomValidity('Password baru harus diisi')">
                            @if ($errors->has('password_baru'))
                            <small class="text-danger">{{ $errors->first('password_baru') }}</small>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="konfirmasi_password_baru">Konfirmasi Password baru <span
                                    class="text-danger">*</span></label>
                            <input type="password" name="konfirmasi_password_baru" id="konfirmasi_password_baru"
                                class="form-control @if ( $errors->has('konfirmasi_password_baru')) is-invalid @endif"
                                required oninput="setCustomValidity('')"
                                oninvalid="this.setCustomValidity('Password lama harus diisi')">
                            @if ($errors->has('konfirmasi_password_baru'))
                            <small class="text-danger">{{ $errors->first('konfirmasi_password_baru') }}</small>
                            @endif
                        </div>
                        <div class="text-center">
                            <a href="/backoffice/user/{{ $user->id }}/profil" class="btn btn-default" title="Kembali">
                                <i class="fa fa-arrow-left"></i>
                            </a>
                            <button type="submit" class="btn btn-warning" style="width: 50%">
                                <i class="fa fa-edit"></i> Ubah password
                            </button>
                        </div>
                    </div>
                </div>

            </form>

        </div>

    </div>

</section>

@endsection
