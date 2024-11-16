<div class="modal fade" id="tambah" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <form role="form" method="POST" action="/backoffice/master-data/shift/create" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Shift</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="card card-outline card-primary">
                        <div class="card-body">
                            <div class="form-group">
                                <label>Shift <span class="text-danger">*</span></label>
                                <input type="text"  name="name" class="form-control @if($errors->has('name')) is-invalid @endif" placeholder="Shift" value="{{ old('name') }}"
                                required oninvalid="this.setCustomValidity('Shift harus diisi')" oninput="this.setCustomValidity('')">
                                @if($errors->has('name'))
                                <small class="help-block" style="color: red">{{ $errors->first('name') }}</small>
                                @endif
                            </div>
                            <div class="form-group">
                                <label>Mulai <span class="text-danger">*</span></label>
                                <input type="time"  name="start" class="form-control @if($errors->has('start')) is-invalid @endif" placeholder="Mulai" value="{{ old('start') }}"
                                required oninvalid="this.setCustomValidity('Mulai harus diisi')" oninput="this.setCustomValidity('')">
                                @if($errors->has('start'))
                                <small class="help-block" style="color: red">{{ $errors->first('start') }}</small>
                                @endif
                            </div>
                            <div class="form-group">
                                <label>Selesai <span class="text-danger">*</span></label>
                                <input type="time"  name="end" class="form-control @if($errors->has('end')) is-invalid @endif" placeholder="Selesai" value="{{ old('end') }}"
                                required oninvalid="this.setCustomValidity('Selesai harus diisi')" oninput="this.setCustomValidity('')">
                                @if($errors->has('end'))
                                <small class="help-block" style="color: red">{{ $errors->first('end') }}</small>
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