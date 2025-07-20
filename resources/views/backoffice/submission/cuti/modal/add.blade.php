<div class="modal fade" id="tambah" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form role="form" method="POST" action="/backoffice/submission/cuti/store" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Cuti</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="card card-outline card-primary">
                        <div class="card-body">
                            @php
                                $tahunIni = date('Y');
                                $userQuota = \App\Models\LeaveQuota::where('user_id', auth()->id())->where('year', $tahunIni)->first();
                                $sisaCuti = $userQuota ? ($userQuota->quota - $userQuota->used) : 30;
                            @endphp
                            <div class="alert alert-info">
                                <i class="fas fa-info-circle"></i> 
                                <strong>Jatah Cuti Tahun {{ $tahunIni }}:</strong> 
                                {{ $userQuota ? $userQuota->quota : 30 }} hari, 
                                <strong>Sisa:</strong> {{ $sisaCuti }} hari
                            </div>
                            
                            <div class="form-group">
                                <label>Mulai Cuti <span class="text-danger">*</span></label>
                                <input type="date"  name="start_date" class="form-control @if($errors->has('start_date')) is-invalid @endif" placeholder="Mulai Cuti" value="{{ old('start_date') }}"
                                required oninvalid="this.setCustomValidity('Mulai cuti harus diisi')" oninput="this.setCustomValidity('')" min="{{ date('Y-m-d') }}">
                                @if($errors->has('start_date'))
                                <small class="help-block" style="color: red">{{ $errors->first('start_date') }}</small>
                                @endif
                            </div>
                            <div class="form-group">
                                <label>Selesai Cuti <span class="text-danger">*</span></label>
                                <input type="date"  name="end_date" class="form-control @if($errors->has('end_date')) is-invalid @endif" placeholder="Selesai Cuti" value="{{ old('end_date') }}"
                                required oninvalid="this.setCustomValidity('Selesai cuti harus diisi')" oninput="this.setCustomValidity('')" min="{{ date('Y-m-d') }}">
                                @if($errors->has('end_date'))
                                <small class="help-block" style="color: red">{{ $errors->first('end_date') }}</small>
                                @endif
                            </div>
                            <div class="form-group">
                                <label>Alasan Cuti <span class="text-danger">*</span></label>
                                <textarea name="description" class="form-control @if($errors->has('description')) is-invalid @endif" placeholder="Alasan Cuti"
                                required oninvalid="this.setCustomValidity('Alasan cuti harus diisi')" oninput="this.setCustomValidity('')"></textarea>
                                @if($errors->has('description'))
                                <small class="help-block" style="color: red">{{ $errors->first('description') }}</small>
                                @endif
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-warning" data-dismiss="modal"><span class="fa fa-arrow-left"></span> Kembali</button>
                    <button type="submit" class="btn btn-success"><span class="fa fa-save"></span> Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>