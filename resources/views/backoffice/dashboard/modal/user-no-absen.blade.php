<div class="modal fade" id="detail-{{ $absen->id }}">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Detail Karyawan</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <div class="card card-outline card-primary">
                    <div class="card-body">
                        <div class=" text-center">
                            <label for="foto">Foto</label>
                            @if ($absen->foto)
                                <img src="{{ Storage::disk('s3')->url($absen->foto) }}" 
                                class="gambarPreviewuser img-fluid d-block" alt=""
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
                                        {{ $absen->name }}
                                    </p>
                                </div>
                                <div class=" d-flex justify-content-between pl-4 pr-4">
                                    <p>
                                        <b>Email:</b> 
                                    </p>
                                    <p>
                                        {{ $absen->email }}
                                    </p>
                                </div>
                                <div class=" d-flex justify-content-between pl-4 pr-4">
                                    <p>
                                        <b>Peran:</b> 
                                    </p>
                                    <p>
                                        {{ $absen->role->name }}
                                    </p>
                                </div>
                                <div class=" d-flex justify-content-between pl-4 pr-4">
                                    <p>
                                        <b>Jenis Kelamin:</b> 
                                    </p>
                                    @if ($absen->gender == null)
                                        <p class="badge badge-warning">
                                            <i class="fa fa-exclamation-triangle"></i> Belum melengkapi data
                                        </p>
                                    @else
                                        <p>
                                            {{ $absen->gender }}
                                        </p>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class=" d-flex justify-content-between pl-4 pr-4">
                                    <p>
                                        <b>Agama:</b> 
                                    </p>
                                    @if ($absen->religion == null)
                                        <p class="badge badge-warning">
                                            <i class="fa fa-exclamation-triangle"></i> Belum melengkapi data
                                        </p>
                                    @else
                                        <p>
                                            {{ $absen->religion }}
                                        </p>
                                    @endif
                                </div>
                                <div class=" d-flex justify-content-between pl-4 pr-4">
                                    <p>
                                        <b>Tempat, Tanggal Lahir:</b> 
                                    </p>
                                    @if ($absen->place_birth == null  && $absen->date_birth == null)
                                        <p class="badge badge-warning">
                                            <i class="fa fa-exclamation-triangle"></i> Belum melengkapi data
                                        </p>
                                    @else
                                        <p>
                                            {{ $absen->place_birth }}, {{ date('d F Y', strtotime($absen->date_birth)) }}
                                        </p>
                                    @endif
                                </div>
                                <div class=" d-flex justify-content-between pl-4 pr-4">
                                    <p>
                                        <b>Alamat:</b> 
                                    </p>
                                    @if ($absen->address == null)
                                        <p class="badge badge-warning">
                                            <i class="fa fa-exclamation-triangle"></i> Belum melengkapi data
                                        </p>
                                    @else
                                        <p>
                                            {{ $absen->address }}
                                        </p>
                                    @endif
                                </div>
                                <div class=" d-flex justify-content-between pl-4 pr-4">
                                    <p>
                                        <b>No Hp:</b> 
                                    </p>
                                    @if ($absen->no_hp == null)
                                        <p class="badge badge-warning">
                                            <i class="fa fa-exclamation-triangle"></i> Belum melengkapi data
                                        </p>
                                    @else
                                        <p>
                                            {{ $absen->no_hp }}
                                        </p>
                                    @endif
                                </div>
                            </div>
                        </div>  
                        
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
