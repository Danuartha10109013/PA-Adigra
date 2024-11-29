<div class="modal fade" id="edit-{{ $submission->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form role="form" method="POST" action="/backoffice/submission/cuti/{{ $submission->id }}/update" enctype="multipart/form-data">
                {{ csrf_field() }}
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">
                        @if ($submission->status == "Ditolak")
                            Sesuaikan pengajuan
                        @else
                            Ubah pengajuan
                        @endif
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @if ($submission->status == "Ditolak")
                        <div class="callout callout-info">
                            <b>Keterangan ditolak:</b> {{ $submission->status_description }}
                        </div>
                    @endif
                    <div class="card card-outline card-primary">
                        <div class="card-body">
                            <input type="hidden" name="type" value="{{ $submission->type }}">
                            <div class="form-group">
                                <label>Mulai Cuti <span class="text-danger">*</span></label>
                                <input type="date"  name="start_date" class="form-control @if($errors->has('start_date')) is-invalid @endif" placeholder="Mulai Cuti" value="{{ $submission->start_date }}"
                                required oninvalid="this.setCustomValidity('Mulai cuti harus diisi')" oninput="this.setCustomValidity('')" >
                                @if($errors->has('start_date'))
                                <small class="help-block" style="color: red">{{ $errors->first('start_date') }}</small>
                                @endif
                            </div>
                            <div class="form-group">
                                <label>Selesai Cuti <span class="text-danger">*</span></label>
                                <input type="date"  name="end_date" class="form-control @if($errors->has('end_date')) is-invalid @endif" placeholder="Selesai Cuti" value="{{ $submission->end_date }}"
                                required oninvalid="this.setCustomValidity('Selesai cuti harus diisi')" oninput="this.setCustomValidity('')" >
                                @if($errors->has('end_date'))
                                <small class="help-block" style="color: red">{{ $errors->first('end_date') }}</small>
                                @endif
                            </div>
                            <div class="form-group">
                                <label>Alasan Cuti <span class="text-danger">*</span></label>
                                <textarea name="description" class="form-control @if($errors->has('description')) is-invalid @endif" placeholder="Alasan Cuti"
                                required oninvalid="this.setCustomValidity('Alasan cuti harus diisi')" oninput="this.setCustomValidity('')">{{ $submission->description }}</textarea>
                                @if($errors->has('description'))
                                <small class="help-block" style="color: red">{{ $errors->first('description') }}</small>
                                @endif
                            </div>
                            @if ($submission->status == "Ditolak")
                                <div class="form-inline">
                                    <input type="checkbox" class="" required oninvalid="this.setCustomValidity('Apakah data sudah sesuai?')" oninput="this.setCustomValidity('')">
                                    <label class="ml-2">Cek apakah data sudah sesuai? <span class="text-danger">*</span></label>
                                </div>
                            @endif
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