<div class="modal fade" id="tambah" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <form role="form" method="POST" action="/backoffice/submission/izin-sakit/store" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Pnegajuan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="card card-outline card-primary">
                        <div class="card-body">
                            <div class="form-group">
                                <label>Mulai Pengajuan <span class="text-danger">*</span></label>
                                <input type="date"  name="start_date" class="form-control @if($errors->has('start_date')) is-invalid @endif" placeholder="Mulai Pengajuan" value="{{ old('start_date') }}"
                                required oninvalid="this.setCustomValidity('Mulai Pengajuan harus diisi')" oninput="this.setCustomValidity('')" min="{{ date('Y-m-d') }}">
                                @if($errors->has('start_date'))
                                <small class="help-block" style="color: red">{{ $errors->first('start_date') }}</small>
                                @endif
                            </div>
                            <div class="form-group">
                                <label>Selesai Pengajuan <span class="text-danger">*</span></label>
                                <input type="date"  name="end_date" class="form-control @if($errors->has('end_date')) is-invalid @endif" placeholder="Selesai Pengajuan" value="{{ old('end_date') }}"
                                required oninvalid="this.setCustomValidity('Selesai Pengajuan harus diisi')" oninput="this.setCustomValidity('')" min="{{ date('Y-m-d') }}">
                                @if($errors->has('end_date'))
                                <small class="help-block" style="color: red">{{ $errors->first('end_date') }}</small>
                                @endif
                            </div>
                            <div class="form-group">
                                <label>Tipe <span class="text-danger">*</span></label>
                                <select name="type" class="form-control @if($errors->has('type')) is-invalid @endif" required
                                oninvalid="this.setCustomValidity('Tipe harus diisi')" oninput="this.setCustomValidity('')">
                                    <option value="">-- Pilih tipe pengajuan --</option>
                                    <option value="sakit">Sakit</option>
                                    <option value="izin">Izin</option>
                                </select>
                                @if($errors->has('type'))
                                <small class="help-block" style="color: red">{{ $errors->first('type') }}</small>
                                @endif
                            </div>
                            <div class="form-group">
                                <label>Alasan Pengajuan <span class="text-danger">*</span></label>
                                <textarea name="description" class="form-control @if($errors->has('description')) is-invalid @endif" placeholder="Alasan Pengajuan"
                                required oninvalid="this.setCustomValidity('Alasan Pengajuan harus diisi')" oninput="this.setCustomValidity('')"></textarea>
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