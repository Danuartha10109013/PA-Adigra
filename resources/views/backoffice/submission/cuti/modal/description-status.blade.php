<div class="modal fade" id="description-status-{{ $submission->id }}">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form role="form" method="POST" action="/backoffice/submission/cuti/{{ $submission->id }}/update-status-description" enctype="multipart/form-data">
                {{ csrf_field() }}
                @method('PUT')
                <div class="modal-header">
                    <h4 class="modal-title">Keterangan pengajuan ditolak</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="card card-outline card-primary">
                        <div class="card-body">
                            <div class="callout callout-info">
                                <b>Keterangan ditolak:</b>
                                {{ $submission->status_description }}
                            </div>
                            @if (auth()->user()->role_id == 1)
                                <div class="callout callout-warning">
                                    <b>Ubah keterangan:</b>
                                    <textarea name="status_description" class="form-control" placeholder="Masukan alasan tolak pengajuan jika akan diubah"
                                    required oninvalid="this.setCustomValidity('Masukan alasan tolak pengajuan jika akan diubah')" oninput="this.setCustomValidity('')"></textarea>
                                    <button type="submit" class="btn btn-warning btn-block btn-sm mt-2">
                                        <i class="fa fa-edit"></i> Ubah keterangan
                                    </button>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-end">
                    <button type="button" class="btn btn-warning" data-dismiss="modal">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
