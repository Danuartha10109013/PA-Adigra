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
        

        <div class="col-md-8">
            <form action="/backoffice/user-data/user/{{ auth()->user()->id }}/ubah-data" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="card">
                    <div class="card-header bg-primary">
                        <h3 class="card-title">Form ubah data</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-primary btn-sm" data-card-widget="collapse" data-toggle="tooltip"
                                title="Collapse">
                                <i class="fas fa-minus"></i></button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="foto_profil">Foto</label>
                                    <input type="hidden" name="foto_profil_lama" value="{{ $user->foto_profil }}">
                                    @if ($user->foto_profil)
                                        <img src="{{ asset('storage/images/user/'.$user->foto_profil) }}" alt="" class="img-fluid foto_profil rounded d-block mb-3" 
                                        style="width: 150px; height: 150px">
                                    @else
                                        <img src="" class="foto_profil img-fluid mb-3 col-sm-5" alt="">
                                    @endif
                                    <input type="file" accept="image/*" name="foto_profil" onchange="previewFotoProfil()" id="foto_profil" class="form-control @if ($errors->has('foto_profil')) is-invalid @endif">
                                    @if ($errors->has('foto_profil'))
                                    <small class="text-danger">{{ $errors->first('foto_profil') }}</small>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="nama">Nama <span class="text-danger">*</span></label>
                                    <input type="text" name="nama" id="nama"
                                        class="form-control @if ($errors->has('nama')) is-invalid @endif"
                                        value="{{ $user->nama }}">
                                    @if ($errors->has('nama'))
                                    <small class="text-danger">{{ $errors->first('nama') }}</small>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="jenis_kelamin">Jenis kelamin <span class="text-danger">*</span></label>
                                    <select name="jenis_kelamin" id="jenis_kelamin" class="form-control {{ $errors->has('jenis_kelamin') ? 'is-invalid' : '' }}">
                                        <option value="">-- Pilih --</option>
                                        <option value="Laki-laki" {{ $user->jenis_kelamin == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                        <option value="Perempuan" {{ $user->jenis_kelamin == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                                    </select>
                                    @if ($errors->has('jenis_kelamin'))
                                    <small class="text-danger">{{ $errors->first('jenis_kelamin') }}</small>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="agama">Agama <span class="text-danger">*</span></label>
                                    <select name="agama" id="agama" class="form-control {{ $errors->has('agama') ? 'is-invalid' : '' }}">
                                        <option value="">-- Pilih --</option>
                                        <option value="Islam" {{ $user->agama == 'Islam' ? 'selected' : '' }}>Islam</option>
                                        <option value="Kristen" {{ $user->agama == 'Kristen' ? 'selected' : '' }}>Kristen</option>
                                        <option value="Katolik" {{ $user->agama == 'Katolik' ? 'selected' : '' }}>Katolik</option>
                                        <option value="Hindu" {{ $user->agama == 'Hindu' ? 'selected' : '' }}>Hindu</option>
                                        <option value="Budha" {{ $user->agama == 'Budha' ? 'selected' : '' }}>Budha</option>
                                        <option value="Konghucu" {{ $user->agama == 'Konghucu' ? 'selected' : '' }}>Konghucu</option>
                                    </select>
                                    @if ($errors->has('agama'))
                                    <small class="text-danger">{{ $errors->first('agama') }}</small>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="tempat_lahir">Tempat Lahir <span class="text-danger">*</span></label>
                                    <input type="text" name="tempat_lahir" id="tempat_lahir"
                                        class="form-control @if ($errors->has('tempat_lahir')) is-invalid @endif"
                                        value="{{ $user->tempat_lahir }}">
                                    @if ($errors->has('tempat_lahir'))
                                    <small class="text-danger">{{ $errors->first('tempat_lahir') }}</small>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="tanggal_lahir">Tanggal Lahir <span class="text-danger">*</span></label>
                                    <input type="date" max="{{ date('Y-m-d') }}" name="tanggal_lahir" id="tanggal_lahir"
                                        class="form-control @if ($errors->has('tanggal_lahir')) is-invalid @endif"
                                        value="{{ $user->tanggal_lahir }}">
                                    @if ($errors->has('tanggal_lahir'))
                                    <small class="text-danger">{{ $errors->first('tanggal_lahir') }}</small>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="alamat">Alamat <span class="text-danger">*</span></label>
                                    <textarea name="alamat" id="alamat" class="form-control @if ($errors->has('alamat')) is-invalid @endif">{{ $user->alamat }}</textarea>
                                    @if ($errors->has('alamat'))
                                    <small class="text-danger">{{ $errors->first('alamat') }}</small>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="no_hp">No. HP <span class="text-danger">*</span></label>
                                    <input type="text" name="no_hp" id="no_hp" class="form-control @if ($errors->has('no_hp')) is-invalid @endif" value="{{ $user->no_hp }}">
                                    @if ($errors->has('no_hp'))
                                    <small class="text-danger">{{ $errors->first('no_hp') }}</small>
                                    @endif
                                </div>
                            </div>
                        </div>
                        
                        
                        {{-- <div class="form-group">
                            <label for="Konfirmasi">Apakah data sudah sesuai? <span class="text-danger">*</span></label>
                            <div>
                                <input type="checkbox" id="konfirmasi" name="konfirmasi" required
                                oninput="setCustomValidity('')" oninvalid="this.setCustomValidity('Konfirmasi apakah data sudah sesuai')">
                                <small for="konfirmasi">Klik jika data sudah sesuai</small>
                            </div>
                        </div> --}}
                        <div class="text-center">
                            <a href="/backoffice/user/{{ $user->id }}/profil" class="btn btn-default" title="Kembali">
                                <i class="fa fa-arrow-left"></i>
                            </a>
                            <button type="submit" class="btn btn-warning" style="width: 50%">
                                <i class="fa fa-edit"></i> Ubah data
                            </button>
                        </div>
                    </div>
                </div>

            </form>

        </div>

    </div>

</section>

@endsection