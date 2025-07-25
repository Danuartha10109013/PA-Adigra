<div class="modal fade" id="edit-{{ $user->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <form role="form" method="POST" action="/backoffice/user/{{ $user->id }}/update" enctype="multipart/form-data">
                {{ csrf_field() }}
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ubah user</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="card card-outline card-primary">
                        <div class="card-body">
                            <div class="form-group">
                                <label>user <span class="text-danger">*</span></label>
                                <input type="text"  name="name" class="form-control @if($errors->has('name')) is-invalid @endif" value="{{ $user->name }}"
                                required oninput="this.setCustomValidity('')" oninvalid="this.setCustomValidity('user harus diisi')">
                                @if($errors->has('name'))
                                <small class="help-block" style="color: red">{{ $errors->first('name') }}</small>
                                @endif
                            </div>
                            <div class="form-group">
                                <label>Mulai <span class="text-danger">*</span></label>
                                <input type="time"  name="start" class="form-control @if($errors->has('start')) is-invalid @endif" value="{{ $user->start }}"
                                required oninput="this.setCustomValidity('')" oninvalid="this.setCustomValidity('Mulai harus diisi')">
                                @if($errors->has('start'))
                                <small class="help-block" style="color: red">{{ $errors->first('start') }}</small>
                                @endif
                            </div>
                            <div class="form-group">
                                <label>Selesai <span class="text-danger">*</span></label>
                                <input type="time"  name="end" class="form-control @if($errors->has('end')) is-invalid @endif" value="{{ $user->end }}"
                                required oninput="this.setCustomValidity('')" oninvalid="this.setCustomValidity('Selesai harus diisi')">
                                @if($errors->has('end'))
                                <small class="help-block" style="color: red">{{ $errors->first('end') }}</small>
                                @endif
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-warning" data-dismiss="modal"><span class="fa fa-arrow-left"></span> Kembali</button>
                    <button type="submit" class="btn btn-success"><span class="fa fa-edit"></span> Ubah</button>
                </div>
            </form>
        </div>
    </div>
</div>