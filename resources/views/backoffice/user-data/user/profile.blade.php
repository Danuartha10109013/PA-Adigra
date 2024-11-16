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
            <li class="breadcrumb-item active">Profil</li>
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
                    <h3 class="card-title">Data</h3>
                    <div class="card-tools">
                        {{-- <a href="/backoffice/user/{{ auth()->user()->id }}/edit-data" class="btn btn-tool btn-sm" title="Ubah Data">
                            <i class="fas fa-edit"></i>
                        </a>
                        <a href="/backoffice/user/{{ auth()->user()->id }}/edit-password" class="btn btn-tool btn-sm" title="Ubah Password">
                            <i class="fas fa-lock"></i>
                        </a> --}}

                        <button class="btn btn-tool" data-toggle="modal" data-target="#edit-data-{{ $user->id }}" title="Ubah Data">
                            <i class="fa fa-edit"></i>
                        </button>

                        @include('backoffice.user-data.user.modal.edit-data')

                        <button class="btn btn-tool" data-toggle="modal" data-target="#edit-password-{{ $user->id }}" title="Ubah Password">
                            <i class="fa fa-lock"></i>
                        </button>

                        @include('backoffice.user-data.user.modal.edit-password')

                        <button type="button" class="btn btn-tool btn-sm" data-card-widget="collapse" data-toggle="tooltip"
                            title="Collapse">
                            <i class="fas fa-minus"></i></button>
                    </div>
                </div>
                <div class="card-body">
                    @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Berhasil </strong>{{ session('success') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    @endif
                    <div class=" text-center">
                        <label for="foto">Foto </label>
                        @if ($user->foto)
                            <img src="{{ Storage::disk('local')->url($user->foto) }}" 
                            class=" img-fluid d-block rounded" alt=""
                            style="width: 150px; height: 150px; margin-left: auto; margin-right: auto">
                        @else
                            <img src="{{ asset('images/profile-default.jpg') }}" class="gambarPreviewuser rounded img-fluid mb-3 d-block" alt=""
                            style="width: 150px; height: 150px; margin-left: auto; margin-right: auto">
                        @endif
                    </div>
                    <hr>

                    <div class="row">
                        <div class="col-md-6">
                            <div class=" d-flex justify-content-between pl-4 pr-4">
                                <p>
                                    <b>Nama:</b> 
                                </p>
                                <p>
                                    {{ $user->name }}
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
                                    <b>Peran:</b> 
                                </p>
                                <p>
                                    {{ $user->role->name }}
                                </p>
                            </div>
                            <div class=" d-flex justify-content-between pl-4 pr-4">
                                <p>
                                    <b>Jenis Kelamin:</b> 
                                </p>
                                @if ($user->gender == null)
                                    <p class="badge badge-warning">
                                        <i class="fa fa-exclamation-triangle"></i> Belum melengkapi data
                                    </p>
                                @else
                                    <p>
                                        {{ $user->gender }}
                                    </p>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class=" d-flex justify-content-between pl-4 pr-4">
                                <p>
                                    <b>Agama:</b> 
                                </p>
                                @if ($user->religion == null)
                                    <p class="badge badge-warning">
                                        <i class="fa fa-exclamation-triangle"></i> Belum melengkapi data
                                    </p>
                                @else
                                    <p>
                                        {{ $user->religion }}
                                    </p>
                                @endif
                            </div>
                            <div class=" d-flex justify-content-between pl-4 pr-4">
                                <p>
                                    <b>Tempat, Tanggal Lahir:</b> 
                                </p>
                                @if ($user->place_birth == null  && $user->date_birth == null)
                                    <p class="badge badge-warning">
                                        <i class="fa fa-exclamation-triangle"></i> Belum melengkapi data
                                    </p>
                                @else
                                    <p>
                                        {{ $user->place_birth }}, {{ date('d F Y', strtotime($user->date_birth)) }}
                                    </p>
                                @endif
                            </div>
                            <div class=" d-flex justify-content-between pl-4 pr-4">
                                <p>
                                    <b>Alamat:</b> 
                                </p>
                                @if ($user->address == null)
                                    <p class="badge badge-warning">
                                        <i class="fa fa-exclamation-triangle"></i> Belum melengkapi data
                                    </p>
                                @else
                                    <p>
                                        {{ $user->address }}
                                    </p>
                                @endif
                            </div>
                            <div class=" d-flex justify-content-between pl-4 pr-4">
                                <p>
                                    <b>No Hp:</b> 
                                </p>
                                @if ($user->no_hp == null)
                                    <p class="badge badge-warning">
                                        <i class="fa fa-exclamation-triangle"></i> Belum melengkapi data
                                    </p>
                                @else
                                    <p>
                                        {{ $user->no_hp }}
                                    </p>
                                @endif
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>

    </div>

</section>

@endsection